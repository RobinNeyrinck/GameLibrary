<template>
	<main v-if="loaded">
		<h1>{{ this.languageData.library_title }}</h1>
		<game-filter
			v-model:perPage="perPage"
			v-model:page="page"
			@previous="setPage"
			@next="setPage"
			:selectedLanguage="selectedLanguage"
		></game-filter>
		<language-switcher
			@languageChange="handleLanguageChange"
			:currentLanguage="selectedLanguage"
			:title="this.languageData.language_title"
		></language-switcher>
		<search-bar
			:currentSearchTerm="searchTerm"
			:title="this.languageData.search_title"
			@searchTermChange="searchGames">
		</search-bar>
		<tag-filter
			:selectedTag="selectedTag"
			:title="this.languageData.tags"
			@tagChange="filterGames">
		</tag-filter>
		<games
			:perPage="perPage"
			:page="page"
			:selectedLanguage="selectedLanguage"
			:searchTerm="this.searchTerm"
			:selectedTag="this.selectedTag"
		></games>
	</main>
</template>

<script>
import GameFilter from '../modules/games/components/GameFilter.vue';
import Games from '../modules/games/components/Games.vue';
import LanguageSwitcher from '../modules/games/components/LanguageSwitcher.vue';
import SearchBar from '../modules/games/components/SearchBar.vue';
import TagFilter from '../modules/games/components/TagFilter.vue';
import LanguageService from '../modules/languages/services/LanguageService.js';
import GameService from '../modules/games/services/GameService.js';

export default {
	name: 'LibraryView',
	components: {
		Games,
		GameFilter,
		LanguageSwitcher,
		SearchBar,
		TagFilter,
	},
	async mounted() {
		this.initializeComponent();
	},
	data() {
		return {
			service: new LanguageService(),
			gameService: new GameService(),
			perPage: 10,
			page: 1,
			selectedLanguage: 'EN',
			searchTerm: '',
			selectedTag: 'Any',
			loaded: false,
		};
	},
	methods: {
		setPage(page) {
			page = parseInt(page);
			if (page < 1) page = 1;
			this.page = page;
		},
		handleLanguageChange(selectedLanguage) {
			if (typeof selectedLanguage === 'string')
				this.service.setLocalStorage(selectedLanguage);
			this.selectedLanguage = selectedLanguage;
			this.remountComponent();
		},
		searchGames(searchTerm) {
			if (typeof searchTerm === 'string')
				this.gameService.setLocalStorage('searchTerm', searchTerm);
			this.searchTerm = searchTerm;
			this.remountComponent();
		},
		filterGames(tag) {
			if (typeof tag === 'string')
				this.gameService.setLocalStorage('selectedTag', tag);
			this.selectedTag = tag;
			this.remountComponent();
		},
		async getLanguage() {
			return await this.service
				.setLanguage(this.service.getFromLocalStorage())
				.getLanguage();
		},
		checkIfLanguageInStorage() {
			const language = this.service.getFromLocalStorage();
			if (language != null) {
				this.selectedLanguage = language;
			} else {
				this.service.setLocalStorage(this.selectedLanguage);
			}
		},
		checkIfFiltersInStorage(){
			const searchTerm = this.gameService.getFromLocalStorage('searchTerm');
			const selectedTag = this.gameService.getFromLocalStorage('selectedTag');
			
			if (searchTerm != null) {
				this.searchTerm = searchTerm;
			} else {
				this.gameService.setLocalStorage('searchTerm', this.searchTerm);
			}

			if (selectedTag != null) {
				this.selectedTag = selectedTag;
			} else {
				this.gameService.setLocalStorage('selectedTag', this.selectedTag);
			}
		},
		async initializeComponent() {
			this.checkIfLanguageInStorage();
			this.checkIfFiltersInStorage();
			this.selectedLanguage = this.service.getFromLocalStorage();
			this.searchTerm = this.gameService.getFromLocalStorage('searchTerm');
			this.selectedTag = this.gameService.getFromLocalStorage('selectedTag');
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
