import { SET_CURRENT_USER, TOGGLE_LOGIN_FORM, TOGGLE_PROFILE_MODAL, LOGOUT, SET_ERROR_LOGIN } from "../action/user";

export const initialState = {
    logged: false,
    loginForm: false,
    profileModal: false,
    currentUser: [],
    token: null,
    errorLogin: false,
};

const reducer = (state = initialState, action = {}) => {
    switch (action.type) {
        case TOGGLE_LOGIN_FORM:
            return {
                ...state,
                loginForm: !state.loginForm
            }
 
        case TOGGLE_PROFILE_MODAL:
            return {
                ...state,
                profileModal: !state.profileModal
            }
        case SET_CURRENT_USER:
            return {
                ...state,
                logged: true,
                currentUser: action.values.data,
                token: action.values.token,
                loginForm: false,
                errorLogin: false
            }
        case LOGOUT:
            return {
                ...state,
                logged: false,
                currentUser: [],
                token: null,
                profileModal: false,
            }
        case SET_ERROR_LOGIN:
            return {
                ...state,
                errorLogin: true
            }
        default:
            return state;
    }
};

export default reducer;
