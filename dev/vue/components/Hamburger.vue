<template>
	<button @click="onClick" :class="classes" type="button">
		<span class="hamburger-box">
			<span class="hamburger-inner"></span>
		</span>
	</button>
</template>

<script>
	import VueTypes from "vue-types"

	const hamburgerTypes = [
		"3dx",
		"3dx-r",
		"3dy",
		"3dy-r",
		"3dxy",
		"3dxy-r",
		"arrow",
		"arrow-r",
		"arrowalt",
		"arrowalt-r",
		"arrowturn",
		"arrowturn-r",
		"boring",
		"collapse",
		"collapse-r",
		"elastic",
		"elastic-r",
		"emphatic",
		"emphatic-r",
		"minus",
		"slider",
		"slider-r",
		"spin",
		"spin-r",
		"spring",
		"spring-r",
		"stand",
		"stand-r",
		"squeeze",
		"vortex",
		"vortex-r",
	];

	export default {
		model: {
			prop: "opened",
			event: "toggle",
		},
		props: {
			opened: VueTypes.bool.isRequired,
			type: VueTypes.oneOf(hamburgerTypes).def("emphatic"),
		},
		methods: {
			onClick(){
				this.$emit("click");
				this.$emit("toggle", !this.opened);
			}
		},
		computed: {
			classes(){
				return {
					"hamburger": true,
					[`hamburger--${this.type}`]: true,
					"is-active": this.opened,
				};
			},
		},
	};
</script>

<style lang="scss" scoped>
	@import "~@scss/components/Hamburger";
</style>
