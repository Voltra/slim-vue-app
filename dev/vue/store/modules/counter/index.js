import { makeModule } from "@/vue/store/utils";
import state from "./state";
import getters from "./getters";
import mutations from "./mutations";
import actions from "./actions";

/*
oneState
oneGetter
ONE_MUTATION
oneAction
*/

export default makeModule({
	state,
	getters,
	mutations,
	actions,
});
