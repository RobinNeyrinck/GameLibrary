<template>
	<section class="filter" v-if="loaded">
		<h3>Filter</h3>
		<input type="number" :value="perPage" @input="updatePerPage" min="1" />

		<button @click="previous">{{ this.languageData.previous_title }}</button>
		<input type="number" :value="page" @input="updatePage" min="1" />
		<button @click="next">{{ this.languageData.next_title }}</button>
	</section>
</template>

<script>
import LanguageService from '../../languages/services/LanguageService.js';

export default {
	name: 'GameFilter',
	props: {
		perPage: {
			required: true,
		},
		page: {
			required: true,
		},
		selectedLanguage: {
			type: String,
		},
	},
	data() {
		return {
			service: new LanguageService(),
			loaded: false,
		};
	},
	emits: ['update:perPage', 'update:page', 'previous', 'next'],
	async mounted() {
		this.languageData = await this.getLanguage();
		this.loaded = true;
	},
	methods: {
		updatePerPage(event) {
			const perPage = parseInt(event.target.value);
			this.$emit('update:perPage', perPage);
		},
		updatePage(event) {
			this.$emit('update:page', parseInt(event.target.value));
		},
		previous() {
			const previousPage = parseInt(this.page) - 1;
			this.$emit('previous', previousPage);
		},
		next() {
			const nextPage = parseInt(this.page) + 1;
			this.$emit('next', nextPage);
		},
		async getLanguage() {
			return await this.service
				.setLanguage(this.selectedLanguage)
				.getLanguage();
		},
	},
};
</script>

<style>
.filter {
	display: flex;
	flex-direction: row;
	align-items: center;
	justify-content: center;
	border: 1px solid black;
	padding: 1rem;
	margin: 1rem;
}
</style>
