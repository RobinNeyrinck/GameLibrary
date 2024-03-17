<script setup></script>

<template>
	<main>
		<Login @login="setLogin" v-if="!isLoggedIn" />
		<AdminGameList v-else="isLoggedIn"></AdminGameList>
	</main>
</template>

<script>
import AdminGameList from '../modules/games/components/AdminGameList.vue';
import Login from '../modules/login/components/Login.vue';

export default {
	name: 'AdminView',
	components: {
		Login,
		AdminGameList,
	},
	data() {
		return {
			isLoggedIn: false,
		};
	},
	methods: {
		setLogin(value) {
			this.isLoggedIn = value;
		},
	},
};
</script>
