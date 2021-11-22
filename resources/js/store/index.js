import { createStore } from 'vuex';
import rangos from './modules/rangos';
import policias from "./modules/policias";
import users from "./modules/users";
import asignacionSillas from "@/store/modules/distribucion/asignacionSillas";
import distributionConfigurations from '@/store/modules/distribucion/distributionConfigurations';

export default createStore({
    modules: {
        Rangos: rangos,
        Policias: policias,
        Users: users,
        AsignacionSillas: asignacionSillas,
        DistributionConfiguraions: distributionConfigurations
    }
});
