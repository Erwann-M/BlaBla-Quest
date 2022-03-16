import React from "react";
import { Formik } from "formik";
import './styles.scss';
import { useDispatch, useSelector } from "react-redux";
import { login } from "../../../action/user";


const LoginForm = () => {

  const dispatch = useDispatch();
  const {errorLogin} = useSelector(state => state.user)

  const handleSubmit = (initialValues) => {
    dispatch(login(initialValues));
  }


  return (
    <Formik
      initialValues={{ email: "", password: "" }}
      onSubmit={handleSubmit}
    >
      {props => {const {values,touched,errors,handleChange,handleBlur,handleSubmit} = props;

        return (
          <form onSubmit={handleSubmit} className="connection">
            <h2>Connexion</h2>
            {errorLogin && <p className="errorLogin">Adresse mail ou mot de passe invalide</p>}
            <label htmlFor="email">Adresse email</label>
            <input
              name="email"
              type="text"
              placeholder="Entrer votre adresse email"
              value={values.email}
              onChange={handleChange}
              onBlur={handleBlur}
              className={errors.email && touched.email && "error"}
            />
            <label htmlFor="email">Mot de passe</label>
            <input
              name="password"
              type="password"
              placeholder="Entrer votre mot de passe"
              value={values.password}
              onChange={handleChange}
              onBlur={handleBlur}
              className={errors.password && touched.password && "error"}
            />
              <button className="connection__submit" type="submit">
                Se connecter
              </button>
          </form>
        );
      }}
    </Formik>
  )};

export default LoginForm;