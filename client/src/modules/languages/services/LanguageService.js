const BASE_URL = 'http://project-laravel.local/api/languages';

export default class LanguageService {
	constructor() {
		this.language = 'all';
	}

	setPage(page) {
		this.page = page;
		return this;
	}

	setLanguage(language) {
		this.language = language;
		return this;
	}

	async getLanguage() {
		const url = `${BASE_URL}?language=${this.language}`;
		const response = await fetch(url);
		const data = await response.json();
		return data[0];
	}

	getFromLocalStorage() {
		return localStorage.getItem('language');
	}

	setLocalStorage(language) {
		localStorage.setItem('language', language);
	}
}
