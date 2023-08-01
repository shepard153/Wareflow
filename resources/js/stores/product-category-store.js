const productCategoryStore = {
    state() {
        return {
            selectedProductCategory: {},
            dialogModalShow: false,
            confirmationModalShow: false,
        };
    },
    actions: {
        modifyProductCategory(context, payload) {
            context.commit('updateSelectedProductCategory', payload.category);

            if (payload.mode === 'edit') {
                context.commit('updateDialogModalShow', true);
            } else {
                context.commit('updateConfirmationModalShow', true);
            }
        },
        toggleDialogModal(context, payload) {
            if (payload === false) {
                context.commit('updateSelectedProductCategory', {});
            }

            context.commit('updateDialogModalShow', payload);
        },
        toggleConfirmationModal(context, payload) {
            context.commit('updateConfirmationModalShow', payload);
        }
    },
    mutations: {
        updateSelectedProductCategory(state, payload) {
            state.selectedProductCategory = payload;
        },
        updateDialogModalShow(state, payload) {
            state.dialogModalShow = payload;
        },
        updateConfirmationModalShow(state, payload) {
            state.confirmationModalShow = payload;
        }
    },
}

export default productCategoryStore;
