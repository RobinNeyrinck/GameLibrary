<template>
	<label for="language-select">{{ this.title }}:</label>
	<select
		id="language-select"
		@change="handleChange"
		v-model="selectedLanguage"
	>
		<option
			v-for="language in languages"
			:value="language.code"
			:key="language.code"
		>
			{{ language.name }}
		</option>
	</select>
</template>

<script>
export default {
	name: 'LanguageSwitcher',
	props: {
		currentLanguage: {
			type: String,
		},
		title: {
			type: String,
		},
	},
	data() {
		return {
			selectedLanguage: this.currentLanguage,
			languages: [
				{ code: 'EN', name: 'English' },
				{ code: 'NL', name: 'Nederlands' },
			],
		};
	},
	emits: ['languageChange'],
	methods: {
		handleChange() {
			this.$emit('languageChange', this.selectedLanguage);
		},
	},
};
</script>
