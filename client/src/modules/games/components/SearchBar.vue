<template>
	<label for="search-bar">{{ this.title }}:</label>
	<input
        type="text"
        id="search-bar"
        v-model="searchTerm" />
    <button type="button" @click="handleInput">{{ this.title }}</button>
</template>

<script>
export default {
	name: 'SearchBar',
	props: {
		currentSearchTerm: {
			type: String,
		},
		title: {
			type: String,
		},
	},
	data() {
		return {
			searchTerm: this.currentSearchTerm,
		};
	},
	emits: ['searchTermChange'],
	methods: {
		handleInput() {
			this.$emit('searchTermChange', this.searchTerm);
		},
	},
};
</script>
