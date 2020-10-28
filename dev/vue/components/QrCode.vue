<template>
<!--	<canvas ref="canvas"></canvas>-->
	<img :src="url" alt="QR code"/>
</template>

<script>
	import VueTypes from "vue-types"
	import QR from "qrcode"

	export default {
		name: "QrCode",
		props: {
			url: VueTypes.string.isRequired,
		},
		/*mounted(){
			QR.toCanvas(this.$refs.canvas, this.url, {
				errorCorrectionLevel: "H",
			}, err => {
				if(err)
					console.error(err);
			});
		},*/
	};
</script>

<style scoped>

</style>
