import { createStore } from 'vuex';
import productCategoryStore from "@/stores/product-category-store.js";

const store = createStore({
    modules: {
        productCategoryStore
    }
});

export default store;
