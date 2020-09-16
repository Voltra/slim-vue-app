import VueRouter from "vue-router";
import Route from "vue-routisan/src";

export default new VueRouter({
	mode: "history",
	routes: Route.all(),
	linkActiveClass: "active",
	linkExactActiveClass: "active--exact",
	scrollBehavior(
		to,
		from,
		savedPosition
	){
		return savedPosition
			? savedPosition
			: {
				x: 0,
				y: 0,
			};
	},
});
