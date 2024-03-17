<template>
	<section id="games">
		<div class="flexcontainer">
			<div class="loader" v-show="!hasGames"></div>
			<game
				v-show="hasGames"
				v-for="game in games"
				:key="game.id"
				:game="game"
				:is-admin="false"
				:currentLanguage="selectedLanguage"
				id="game"
			></game>
		</div>
	</section>
</template>

<script>
import LanguageService from '../../languages/services/LanguageService.js';
import GameService from '../services/GameService.js';
import Game from './Game.vue';

export default {
	components: {
		Game,
	},
	props: {
		page: {
			type: Number,
			default: 1,
		},
		perPage: {
			type: Number,
			default: 10,
		},
		selectedLanguage: {
			type: String,
			default: 'EN',
		},
		searchTerm: {
			type: String,
			default: '',
		},
		selectedTag: {
			type: String,
			default: '',
		},
	},
	data() {
		return {
			service: new GameService(),
			games: false,
			loaded: false,
			currentLanguage: this.selectedLanguage,
			languageService: new LanguageService(),
			currentSearchTerm: this.searchTerm,
			currentTag: this.selectedTag,
		};
	},
	watch: {
		perPage: {
			handler: async function () {
				if (!this.loaded) return;
				this.games = await this.loadGames();
			},
			immediate: true,
		},
		page: {
			handler: async function () {
				if (!this.loaded) return;
				this.games = await this.loadGames();
			},
			immediate: true,
		},
		selectedLanguage: async function (newLanguage) {
			this.currentLanguage = newLanguage;
			this.games = await this.loadGames();
		},
		searchTerm: async function (newSearchTerm) {
			this.currentSearchTerm = newSearchTerm;
			this.games = await this.loadGames();
		},
		selectedTag: async function (newTag) {
			this.currentTag = newTag;
			this.games = await this.loadGames();
		},
	},
	computed: {
		hasGames() {
			return this.games !== false;
		},
	},
	async mounted() {
		this.games = await this.loadGames();
	},
	methods: {
		async loadGames() {
			return await this.service
				.setPage(this.page)
				.setPerPage(this.perPage)
				.setLanguage(this.currentLanguage)
				.setTitle(this.currentSearchTerm)
				.setTag(this.currentTag)
				.all();
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
	flex-basis: 25%;
}
</style>
