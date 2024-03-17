<template>
	<label for="tag-select">{{ this.title }}:</label>
	<select
		id="tag-select"
		@change="handleChange"
		v-model="selectedTag"
	>
		<option
			v-for="tag in tags"
			:value="tag"
			:key="tag"
		>
			{{ tag }}
		</option>
	</select>
</template>

<script>
export default {
	name: 'TagFilter',
	props: {
		currentTag: {
			type: String,
		},
		title: {
			type: String,
		},
	},
	data() {
		return {
			selectedTag: this.currentTag,
			tags: [
				"Any",
				"Multiplayer",
                "Shooter",
                "Action",
                "Adventure",
			],
		};
	},
	emits: ['tagChange'],
	methods: {
		handleChange() {
			this.$emit('tagChange', this.selectedTag);
		},
	},
};
</script>
