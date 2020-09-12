<template>
    <div class="demo">
        {{ str }}
    </div>
</template>

<script>
	import VueTypes from "vue-types"

	export default {
		name: "demo",
        props: {
			str: VueTypes.string.isRequired,
        }
	}
</script>

<style lang="scss" scoped>
    .demo{
        background-color: aqua;
        color: green;
    }
</style>
