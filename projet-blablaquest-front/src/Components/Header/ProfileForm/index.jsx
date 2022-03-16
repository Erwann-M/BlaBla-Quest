import './styles.scss';

import React, { useState } from "react";
import { withFormik, Form, Field } from "formik";
import { useDispatch } from 'react-redux';
import AvatarUpload from "./Avatar"
import classNames from "classnames";
import * as Yup from 'yup'
import { logout } from '../../../action/user';
import { useSelector } from 'react-redux';
import { NavLink } from 'react-router-dom';

const ProfileModalForm = ({ values, errors, touched, isSubmitting, }) => {
  const dispatch = useDispatch();

  const handleDeconnection = () => {
    dispatch(logout())
  }
  
  const [picture] = useState();
  const { currentUser } = useSelector(state => state.user);

  return (
    <div className="background__modal">

      <Form className="profile-form__main-container">
        <h1 className="profile-form__main-container__title">Votre profil</h1>
        <div className="profile-form">
          <div className="profile-form__group__avatar">
            <AvatarUpload />
          </div>

          <div className="profile-form__info">
            <div className="profile-form__group">
              <label htmlFor="nickname">Pseudo</label>
              <Field
                id="nickname"
                className={classNames({
                  "form-control": true,
                  "is-valid": touched.nickname && !errors.nickname,
                  "is-invalid": touched.nickname && errors.nickname
                })}
                type="string"
                name="nickname"
                placeholder={currentUser.nickname}
              />
              {touched.nickname && errors.nickname && (
                <div className="invalid-feedback">{errors.nickname}</div>
              )}
              
            </div>

            <div className="profile-form__group">
              <label htmlFor="email">Adresse email</label>
              <Field
                id="email"
                className={classNames({
                  "form-control": true,
                  "is-valid": touched.email && !errors.email,
                  "is-invalid": touched.email && errors.email
                })}
                type="email"
                name="email"
                placeholder={currentUser.email}
              />
              {touched.email && errors.email && (
                <div className="invalid-feedback">{errors.email}</div>
              )}
              
            </div>

            <div className="profile-form__group">
              <label htmlFor="passowrd">Mot de passe</label>
              <Field
                id="password"
                className={classNames({
                  "form-control": true,
                  "is-valid": touched.password && !errors.password,
                  "is-invalid": touched.password && errors.password
                })}
                type="password"
                name="password"
                placeholder="Votre mot de passe"
              />
              {touched.password && errors.password && (
                <div className="invalid-feedback">{errors.password}</div>
              )}
              
            </div>

            <div className="profile-form__group">
              <label htmlFor="passwordconfirm">Confirmation Mot de passe</label>
              <Field
                id="passwordconfirm"
                className={classNames({
                  "form-control": true,
                  "is-valid": touched.passwordconfirm && !errors.passwordconfirm,
                  "is-invalid": touched.passwordconfirm && errors.passwordconfirm
                })}
                type="password"
                name="passwordconfirm"
                placeholder="Confirmez votre mot de passe"
              />
              {touched.passwordconfirm && errors.passwordconfirm && (
                <div className="invalid-feedback">{errors.passwordconfirm}</div>
              )}
              
            </div>

            <div className="profile-form__group">
              <label htmlFor="area">Départements</label>
              <Field
                id="area"
                className={classNames({
                  "form-control": true,
                  "is-valid": touched.area && !errors.area,
                  "is-invalid": touched.area && errors.area
                })}
                type="string"
                name="area"
                placeholder={currentUser.area}
              />
              {touched.area && errors.area &&
                (
                  <div className="invalid-feedback">{errors.area}</div>
                ) 

              }
                
            </div>
          </div>
        </div>
        <div className="buttons">
          <button type="submit" className="btn-profile btn-primary" disabled={isSubmitting}>
            Confirmer
          </button>
          <NavLink to="/" >
            <button className="btn-profile deconnection" onClick={handleDeconnection}>
              Déconnection
            </button>
          </NavLink>
        </div>
      </Form>
    </div>
  )};

const ProfileForm = withFormik({
  mapPropsToValues({ nickname, email, password, area, terms }) {
    return {
      nickname: nickname || "",
      email: email || "",
      password: password || "",
      area: area || "",
    };
  },
  validationSchema: Yup.object().shape({
    nickname: Yup.string()
    .min(4, "Le pseudo doit comporter 4 caractères ou plus")
    .max(15, "Le pseudo doit comporter 15 caractères maximum")
    .required("Un pseudo est obligatoire"),
    email: Yup.string()
      .email("Cet email n'est pas valide")
      .required("Un email est obligatoire"),
    password: Yup.string()
      .min(6, "Le mot de passe doit comporter 6 caractères ou plus")
      .max(25, "Le mot de passe doit comporter 25 caractères maximum")
      .required("Le mot de passe est requis"),
    passwordconfirm: Yup.string()
      .oneOf([Yup.ref("password"), null],"Les mots de passe ne correspondent pas")
      .required("Confirmation de mot de passe requise"),
    area: Yup.number()
      .typeError("Veuillez entrer un chiffre")
      .min(1, "Le numéro de département doit être compris entre 01 et 101")
      .max(101, "Le numéro de département doit être compris entre 01 et 101")
      .required("Un numéro de département est requis"),
  }),
  handleSubmit(values, { resetForm, setErrors, setSubmitting }) {
    console.log(values);
    setTimeout(() => {
      if (values.email === "blabla@quest.io") {
        setErrors({ email: "Cet email est déjà pris" });
      } else {
        resetForm();
      }
      setSubmitting(false);
    }, 2000);
  }
})(ProfileModalForm);


export default ProfileForm;
