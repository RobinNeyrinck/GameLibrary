<template>
	<div id="login-form" v-if="!showRegistration && loaded">
		<h1>Login</h1>
		<form @submit.prevent="login">
			<label for="username">{{ this.languageData.username }}:</label>
			<input type="text" id="username" name="username" v-model="username" />

			<label for="password">{{ this.languageData.password }}:</label>
			<input type="password" id="password" name="password" v-model="password" />

			<div>
				<input type="submit" value="Submit" />
				<button @click="showRegistrationForm" type="button">{{ this.languageData.register_title }}</button>
			</div>
		</form>
	</div>

	<div>
		<Registration v-if="showRegistration" @cancel="setLoginVisibility" />
	</div>
</template>

<script>
import LoginService from '../services/LoginService.js';
import Registration from './Registration.vue';
import LanguageService from '../../languages/services/LanguageService.js';

export default {
	name: 'Login',
	components: {
		Registration,
	},
	data() {
		return {
			service: new LoginService(),
			showRegistration: false,
			isLoginVisible: false,
			username: '',
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
	emits: ['login'],
	methods: {
		async login() {
			const result = await this.service.login(this.username, this.password);
			if (result != false) {
				this.service.putInStorage(result);
				this.$emit('login', true);
			}
			else{
				alert('Wrong username or password');
			}
		},
		showRegistrationForm() {
			this.showRegistration = true;
		},
		setLoginVisibility(value) {
			this.showRegistration = value;
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

<style scoped>
#login-form form {
	display: flex;
	flex-direction: column;
	width: 100%;
}

#login-form label {
	margin: 0.5rem 0;
}

#login-form div {
	display: flex;
	justify-content: space-between;
}

#login-form div button,
#login-form div input[type='submit'] {
	margin: 1rem 0;
}
</style>
