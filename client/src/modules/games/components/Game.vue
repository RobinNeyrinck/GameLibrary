<template>
	<article class="game" v-if="loaded">
		<h3>{{ game.title }}</h3>
		<p>{{ this.languageData.rating }}: {{ game.rating }}</p>
		<p>{{ this.languageData.price }}: {{ game.price }}</p>
		<p>{{ game.languages[0].description }}</p>
		<ul>
			<li v-for="tag in game.languages[0].tags">{{ tag }}</li>
		</ul>
		<div v-if="isAdmin">
			<button @click="editGame">{{ this.languageData.edit_title }}</button>
			<button @click="deleteGame">{{ this.languageData.delete }}</button>
		</div>
	</article>
</template>

<script>
import GameService from '../services/GameService.js';
import LanguageService from '../../languages/services/LanguageService.js';

export default {
	name: 'Game',
	props: {
		game: {
			type: Object,
			required: true,
		},
		isAdmin: {
			type: Boolean,
			default: false,
		},
	},
	data() {
		return {
			service: new GameService(),
			languageService: new LanguageService(),
			loaded: false,
			currentLanguage: 'EN',
		};
	},
	async mounted() {
		this.checkIfLanguageInStorage();
		this.languageData = await this.getLanguage();
		this.loaded = true;
	},
	emits: ['deleted'],
	methods: {
		async deleteGame() {
			const result = await this.service.delete(this.game.id);
			if (result) {
				this.$emit('deleted', true);
			}
		},
		editGame() {
			this.$router.push({ name: 'edit-game', params: { id: this.game.id } });
		},
		async getLanguage() {
			return await this.languageService
				.setLanguage(this.languageService.getFromLocalStorage())
				.getLanguage();
		},
		checkIfLanguageInStorage(){
			const language = this.languageService.getFromLocalStorage();
			if (language != null) {
				this.currentLanguage = language;
			}
			else{
				this.languageService.setLocalStorage(this.currentLanguage);
			}
		},
	},
	computed: {},
};
</script>

<style>
.game {
	border: 1px solid #ccc;
	border-radius: 4px;
	padding: 1rem;
	margin: 0.5rem;
}

.game div {
	padding: 0.1rem;
	display: flex;
	flex-flow: row;
	justify-content: space-between;
}
</style>
