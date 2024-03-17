const BASE_URL = 'http://project-laravel.local/api/';

export default class LoginService {
	async register(name, email, password) {
		const url = `${BASE_URL}register`;
		const body = {
			name: name,
			email: email,
			password: password,
		};

		const response = await fetch(url, {
			headers: {
				'Content-Type': 'application/json',
			},
			method: 'POST',
			body: JSON.stringify(body),
		});

		const data = await response.json();
		return data;
	}

	async login(email, password) {
		const url = `${BASE_URL}login`;
		const body = {
			email: email,
			password: password,
		};

		const response = await fetch(url, {
			headers: {
				'Content-Type': 'application/json',
			},
			credentials: 'include',
			method: 'POST',
			body: JSON.stringify(body),
		});

		const data = await response.json();

		if (data.status === 'success') {
			return data.token;
		} else {
			return false;
		}
	}

	putInStorage(token) {
		return window.sessionStorage.setItem('token', token);
	}

	getFromStorage() {
		return window.sessionStorage.getItem('token');
	}
}
