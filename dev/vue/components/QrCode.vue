<template>
	<img :src="url" alt="QR code"/>
</template>

<script>
	import VueTypes from "vue-types"

	export default {
		name: "QrCode",
		props: {
			url: VueTypes.string.isRequired,
		},
	};
</script>

<style scoped>

</style>
