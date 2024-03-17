const BASE_URL = 'http://project-laravel.local/api/games';
import LoginService from '../../login/services/LoginService';

export default class GameService {
	constructor() {
		this.page = 1;
		this.perPage = 10;
		this.language = 'all';
		this.title = '';
		this.tag = 'Any';
		this.LoginService = new LoginService();
	}

	setPage(page) {
		this.page = page;
		return this;
	}

	setPerPage(perPage) {
		this.perPage = perPage;
		return this;
	}

	setLanguage(language) {
		this.language = language;
		return this;
	}

	setTitle(title) {
		this.title = title;
		return this;
	}

	setTag(tag) {
		this.tag = tag;
		return this;
	}

	async all() {
		const url = `${BASE_URL}?page=${this.page}&per_page=${this.perPage}&language=${this.language}&title=${this.title}&tag=${this.tag}`;
		const response = await fetch(url);
		const data = await response.json();

		if (this.title !== '' || (this.tag !== '' && this.tag !== 'Any')) {
			return data;
		} else {
			return data.data;
		}
	}

	async find(id) {
		const response = await fetch(`${BASE_URL}/${id}?language=${this.language}`);
		const data = await response.json();
		return data;
	}

	async delete(id) {
		await fetch(`${BASE_URL}/${id}`, {
			method: 'DELETE',
			headers: {
				Authorization: `Bearer ${this.LoginService.getFromStorage()}`,
			},
		});
		return true;
	}

	async update(data) {
		const body = {
			title: data.title,
			price: data.price,
			rating: data.rating,
		};
		const response = await fetch(`${BASE_URL}/${data.id}`, {
			method: 'PUT',
			headers: {
				Authorization: `Bearer ${this.LoginService.getFromStorage()}`,
				'Content-Type': 'application/json',
			},
			body: JSON.stringify(body),
		});
		const responseData = await response.json();
		return responseData;
	}

	async create(data) {
		if (data.tags) {
			data.tags = data.tags.split(',');
		}
		const body = {
			title: data.title,
			price: data.price,
			rating: data.rating,
			language: data.language,
			description: data.description,
			tags: data.tags,
		};
		const response = await fetch(`${BASE_URL}`, {
			method: 'POST',
			headers: {
				Authorization: `Bearer ${this.LoginService.getFromStorage()}`,
				'Content-Type': 'application/json',
			},
			body: JSON.stringify(body),
		});
		const responseData = await response.json();
		if (responseData.status != 400) {
			return true;
		}
	}

	getFromLocalStorage(key) {
		return localStorage.getItem(key);
	}

	setLocalStorage(key, value) {
		localStorage.setItem(key, value);
	}
}
