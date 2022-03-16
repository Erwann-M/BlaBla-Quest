export const TOGGLE_LOGIN_FORM = "TOGGLE_LOGIN_FORM";
export const TOGGLE_PROFILE_MODAL = "TOGGLE_PROFILE_MODAL";

export const toggleLoginForm = () => (
  {
    type: TOGGLE_LOGIN_FORM,
  }
);

export const toggleProfileModal = () => (
  {
    type: TOGGLE_PROFILE_MODAL,
  }
)
export const LOGIN = "LOGIN";

export const login = (values) => (
  {
    type: LOGIN,
    values
  }
);

export const LOGOUT = "LOGOUT";

export const logout = () => (
  {
    type: LOGOUT,
  }
)

export const REGISTER = "REGISTER";

export const register = (values) => (
  {
    type: REGISTER,
    values
  }
);

export const SET_CURRENT_USER = "SET_CURRENT_USER";

export const setCurrentUser = (values) => (
  {
    type: SET_CURRENT_USER,
    values
  }
);

export const SET_ERROR_LOGIN = "SET_ERROR_LOGIN";

export const setErrorLogin = () => (
  {
    type: SET_ERROR_LOGIN,
  }
);

