<template>
	<div v-if="loaded">
		<h1>{{ this.languageData.add_title }}</h1>
		<form class="form" @submit.prevent="onGameSubmit">
			<label for="title">{{ this.languageData.title }}</label>
			<input type="text" id="title" class="form-input" v-model="game.title" />
			<label for="rating">{{ this.languageData.rating }}</label>
			<input type="number" id="rating" class="form-input" v-model="game.rating" />
			<label for="price">{{ this.languageData.price }}</label>
			<input type="number" id="price" class="form-input" v-model="game.price" />

			<label for="language">{{ this.languageData.language_title }}</label>
			<input
				type="text"
				id="language"
				class="form-input"
				v-model="game.language"
			/>
			<label for="description">{{ this.languageData.description }}</label>
			<input
				type="text"
				id="description"
				class="form-input"
				v-model="game.description"
			/>
			<label for="tags"
				>{{ this.languageData.tags }} ({{ this.languageData.tags_description }})</label
			>
			<input type="text" id="tags" class="form-input" v-model="game.tags" />

			<button type="submit">{{ this.languageData.add_title }}</button>
			<button type="button" @click="resetForm">{{ this.languageData.cancel }}</button>
		</form>
	</div>
</template>

<script>
import GameService from '../modules/games/services/GameService.js';
import LanguageService from '../modules/languages/services/LanguageService.js';

export default {
	name: 'AddGameView',
	data() {
		return {
			game: {
				title: '',
				rating: 0,
				price: 0,
				description: '',
				language: '',
				tags: '',
			},
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
	methods: {
		resetForm() {
			this.$router.push(`/admin`);
		},
		async onGameSubmit() {
			const result = await this.service.create(this.game);
			if (result) {
				this.$router.push(`/admin`);
			}
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
				this.languageService.setLocalStorage(this.selectedLanguage);
			}
		},
	},
};
</script>
<style>
#app {
	width: 50%;
}

h1 {
	font-size: 24px;
	margin-bottom: 20px;
}

label {
	display: block;
	margin-bottom: 5px;
}

.form-input {
	width: 100%;
	padding: 10px;
	font-size: 16px;
	margin-bottom: 10px;
}

.form-button {
	background-color: #3490dc;
	color: white;
	padding: 10px 20px;
	border: none;
	border-radius: 5px;
	font-size: 16px;
	cursor: pointer;
}

.form-button:hover {
	background-color: #2779bd;
}
</style>
