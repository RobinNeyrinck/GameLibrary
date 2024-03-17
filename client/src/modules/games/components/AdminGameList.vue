<template>
	<div v-if="loaded">
		<h1>Admin {{ this.languageData.library_title }}</h1>
		<language-switcher
			@languageChange="handleLanguageChange"
			:currentLanguage="selectedLanguage"
			:title="this.languageData.language_title"
		></language-switcher>
		<button @click.prevent="onAddClick">{{ this.languageData.add_title }}</button>
		<div class="flexcontainer">
			<game
				v-show="games || games.length > 0"
				v-for="game in games"
				:key="game.id"
				:game="game"
				id="game"
				:isAdmin="true"
				:currentLanguage="selectedLanguage"
				@deleted="getGames"
			></game>
		</div>
	</div>
</template>

<script>
import GameService from '../services/GameService.js';
import Game from './Game.vue';
import LanguageSwitcher from './LanguageSwitcher.vue';
import LanguageService from '../../languages/services/LanguageService.js';

export default {
	name: 'AdminGameList',
	components: {
		Game,
		LanguageSwitcher
	},
	data() {
		return {
			service: new GameService(),
			games: false,
			languageService: new LanguageService(),
			loaded: false,
			selectedLanguage: 'EN',
		};
	},
	watch: {},
	computed: {},
	async mounted() {
		this.checkIfLanguageInStorage();
		this.languageData = await this.getLanguage();
		await this.getGames();
		this.loaded = true;
	},
	methods: {
		async getGames() {
			const games = await this.service
							.setPage(1)
							.setPerPage(10)
							.setLanguage(this.selectedLanguage)
							.all();
			this.games = games;
		},
		onAddClick() {
			this.$router.push({ name: 'add-game' });
		},
		handleLanguageChange(selectedLanguage) {
			if (typeof selectedLanguage === 'string')
				this.languageService.setLocalStorage(selectedLanguage);
				this.selectedLanguage = selectedLanguage;
				this.remountComponent();
		},
		async getLanguage() {
			return await this.languageService
				.setLanguage(this.languageService.getFromLocalStorage())
				.getLanguage();
		},
		checkIfLanguageInStorage(){
			const language = this.languageService.getFromLocalStorage();
			if (language != null) {
				this.selectedLanguage = language;
			}
			else{
				this.languageService.setLocalStorage(this.selectedLanguage);
			}
		},
		async initializeComponent() {
			this.checkIfLanguageInStorage();
			this.selectedLanguage = this.languageService.getFromLocalStorage();
			this.languageData = await this.getLanguage();
			await this.getGames();
			this.loaded = true;
		},
		remountComponent() {
			this.loaded = false;
			this.initializeComponent();
		},
	},
};
</script>

<style>
.flexcontainer {
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
}

#game {
	flex-basis: 30%;
}
</style>
