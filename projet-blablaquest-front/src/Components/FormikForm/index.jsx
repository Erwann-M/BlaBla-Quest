import './styles.scss';
import { Form, Field, Formik, } from "formik";
import AvatarUpload from "../../Components/FormikForm/Avatar"
import classNames from "classnames";
import * as Yup from "yup"
import { useDispatch} from 'react-redux';
import { register } from '../../action/user';
import departements from '../../departements';



const profileValidationSchema = Yup.object().shape({
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
    .required("Un numéro de département est requis"),
  terms: Yup.boolean().oneOf(
    [true],
    "Vous devez accepter les termes et conditions"
  )
})

const RegistrationForm = () => {

  const dispatch = useDispatch();

  const handleSubmit = (initialValues) => {
    console.log(initialValues);
    dispatch(register(initialValues))
  }

  return (

    <Formik
      initialValues={{nickname: "", email: "", password: "", passwordconfirm: "" ,area:"" , terms: false}}
      onSubmit={handleSubmit}
      validationSchema={profileValidationSchema}
    >
      {props => {const {values,touched,errors,isSubmitting,handleSubmit} = props;
      return (

      <Form onSubmit={handleSubmit} className="register-form">
        
        <div className="register-form__group__avatar">
          <AvatarUpload />
        </div>

        <div className="register-form__group">
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
            placeholder="Votre pseudo"
          />
          {touched.nickname && errors.nickname && (
            <div className="invalid-feedback">{errors.nickname}</div>
          )}
          
        </div>

        <div className="register-form__group">
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
            placeholder="Votre adresse email"
          />
          {touched.email && errors.email && (
            <div className="invalid-feedback">{errors.email}</div>
          )}
          
        </div>

        <div className="register-form__group">
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

        <div className="register-form__group">
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

        <div className="register-form__group">
        <label htmlFor="area">Départements</label>
        <Field
          id="area"
          className={classNames({
            "form-control": true,
            "is-valid": touched.area && !errors.area,
            "is-invalid": touched.area && errors.area
          })}
          as="select"
          name="area"
        >
          <option selected disabled value="" >--Choisis ton département--</option>
          {
            departements.map((departement) => (
              <option value={departement.num_dep} >[{departement.num_dep}] {departement.dep_name}</option>
            ))
          }
        </Field>
        {touched.area && errors.area ?
          <div className="invalid-feedback">{errors.area}</div>
          : <div></div>
        }
          
      </div>

        <div className="register-form__check">
          <Field
            id="terms"
            className={classNames({
              "form-check-input": true,
              "is-invalid": touched.terms && errors.terms
            })}
            type="checkbox"
            name="terms"
            checked={values.terms}
          />
          <label
            className={classNames({
              "form-check-label": true,
              "is-invalid": touched.terms && errors.terms
            })}
            htmlFor="terms"
          >
            Accepter les termes et conditions
          </label>
          {touched.terms && errors.terms && (
            <div className="invalid-feedback">{errors.terms}</div>
          )}
        </div>

        <button type="submit" className="btn btn-primary" disabled={isSubmitting}>
          Confirmer
        </button>
      </Form>
      
    )}}
      </Formik>
  );
}

export default RegistrationForm;
