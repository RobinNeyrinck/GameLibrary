<template>
	<div class="edit-game" v-if="loaded">
		<h1>{{ this.languageData.edit_title }}: {{ game.title }}</h1>
		<form @submit.prevent="updateGame" class="game-form">
			<label for="title">{{ this.languageData.title }}:</label>
			<input type="text" id="title" v-model="game.title" class="form-input" />

			<label for="rating">{{ this.languageData.rating }}:</label>
			<input
				type="number"
				id="rating"
				v-model="game.rating"
				class="form-input"
			/>

			<label for="price">{{ this.languageData.price }}:</label>
			<input type="number" id="price" v-model="game.price" class="form-input" />

			<button type="submit" class="form-button">{{ this.languageData.edit_title }}</button>
		</form>
	</div>
</template>

<script>
import GameService from '../modules/games/services/GameService.js';
import LanguageService from '../modules/languages/services/LanguageService.js';

export default {
	name: 'EditGameView',
	data() {
		return {
			service: new GameService(),
			game: false,
			languageService: new LanguageService(),
			loaded: false,
			currentLanguage: 'EN',
		};
	},
	async mounted() {
		const id = parseInt(this.$route.params.id);
		this.game = await this.loadGame(id);
		this.checkIfLanguageInStorage();
		this.languageData = await this.getLanguage();
		this.loaded = true;
	},
	methods: {
		async loadGame(id) {
			const game = await this.service.find(id);
			return game;
		},
		async updateGame() {
			await this.service.update(this.game);
			this.$router.push(`/admin`);
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
.edit-game {
	width: 100%;
	margin: 0 auto;
	padding: 20px;
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

.form-textarea {
	width: 100%;
	height: 150px; /* Fixed height */
	padding: 10px;
	font-size: 16px;
	margin-bottom: 10px;
	resize: none; /* Prevent resizing */
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
