<template>
	<main v-if="loaded">
		<h1>Home</h1>
		<language-switcher
			@languageChange="handleLanguageChange"
			:currentLanguage="selectedLanguage"
			:title="this.languageData.language_title"
		></language-switcher>
		<p>
			{{ languageData.home_description }}
		</p>
	</main>
</template>

<script>
import LanguageSwitcher from '../modules/games/components/LanguageSwitcher.vue';
import LanguageService from '../modules/languages/services/LanguageService.js';

export default {
	name: 'HomeView',
	components: {
		LanguageSwitcher,
	},
	data() {
		return {
			service: new LanguageService(),
			loaded: false,
			selectedLanguage: 'EN',
		};
	},
	async mounted() {
		this.checkIfLanguageInStorage();
		this.languageData = await this.getLanguage();
		this.loaded = true;
	},
	methods: {
		handleLanguageChange(selectedLanguage) {
			if (typeof selectedLanguage === 'string')
				this.service.setLocalStorage(selectedLanguage);
				this.selectedLanguage = selectedLanguage;
				this.remountComponent();
		},
		async getLanguage() {
			return await this.service
				.setLanguage(this.service.getFromLocalStorage())
				.getLanguage();
		},
		checkIfLanguageInStorage(){
			const language = this.service.getFromLocalStorage();
			if (language != null) {
				this.selectedLanguage = language;
			}
			else{
				this.service.setLocalStorage(this.selectedLanguage);
			}
		},
		async initializeComponent() {
			this.checkIfLanguageInStorage();
			this.selectedLanguage = this.service.getFromLocalStorage();
			this.languageData = await this.getLanguage();
			this.loaded = true;
		},
		remountComponent() {
			this.loaded = false;
			this.initializeComponent();
		},
	},
};
</script>
