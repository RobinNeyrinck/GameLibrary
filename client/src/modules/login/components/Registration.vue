<template>
	<div id="registration-form" v-if="loaded">
		<h1>{{ this.languageData.register_title }}</h1>
		<form @submit.prevent="register">
			<label for="username" aria-required="true">{{ this.languageData.username }}</label>
			<input type="text" id="name" v-model="name" />
			<label for="email">E-Mail</label>
			<input type="email" id="email" v-model="email" />
			<label for="password">{{ this.languageData.password }}</label>
			<input type="password" id="password" v-model="password" />

			<div>
				<input type="submit" value="Submit" />
				<button type="button" @click="cancel">{{ this.languageData.cancel }}</button>
			</div>
		</form>
	</div>
</template>

<script>
import LoginService from '../services/LoginService.js';
import LanguageService from '../../languages/services/LanguageService.js';

export default {
	name: 'Registration',
	data() {
		return {
			service: new LoginService(),
			name: '',
			email: '',
			password: '',
			languageService: new LanguageService(),
			loaded: false,
			currentLanguage: 'EN',
		};
	},
	async mounted() {
		const token = this.service.getFromStorage();
		if (token != null) {
			this.$emit('login', true);
		}
		this.checkIfLanguageInStorage();
		this.languageData = await this.getLanguage();
		this.loaded = true;
	},
	emits: ['cancel'],
	methods: {
		register() {
			this.service.register(this.name, this.email, this.password);
			this.$emit('cancel', false);
		},
		cancel() {
			this.$emit('cancel', false);
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
};
</script>

<style scoped>
#registration-form form {
	display: flex;
	flex-direction: column;
}

#registration-form label {
	margin: 0.25rem 0;
}

#registration-form div {
	margin: 0.5rem 0;
	display: flex;
	justify-content: space-between;
}
</style>
