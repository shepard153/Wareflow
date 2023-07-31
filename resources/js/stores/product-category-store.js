const productCategoryStore = {
    state() {
        return {
            productCategory: {},
            confirmationModalShow: false,
        };
    },
    actions: {
        deleteProductCategory(context, payload) {
            context.commit('updateDeleteProductCategory', payload);
            context.commit('toggleConfirmationModal', true);
        },
        toggleConfirmationModal(context, payload) {
            context.commit('toggleConfirmationModal', payload);
        }
    },
    mutations: {
        updateDeleteProductCategory(state, payload) {
            state.productCategory = payload;
        },
        toggleConfirmationModal(state, payload) {
            state.confirmationModalShow = payload;
        }
    },
}

export default productCategoryStore;
