import './styles.scss';
import { Formik, Form, Field, useFormikContext, useField } from "formik";
import { NavLink } from 'react-router-dom';
import classNames from "classnames";
import * as Yup from 'yup';
import { useEffect } from 'react';
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import { useDispatch, useSelector } from 'react-redux';
import departements from '../../departements';
import { addEvent, getGameFromApi } from '../../action/event';

const validationSchema = Yup.object().shape({
  title: Yup.string()
  .min(4, "Le titre doit comporter 4 caractères ou plus")
  .required("Un titre est obligatoire"),
  event: Yup.string()
    .min(8, "Une description d'événement doit comporter 8 caractères ou plus")
    .required("Une description d'événement est obligatoire"),
  localisation: Yup.string()
    .required("Une localisation est obligatoire"),
})

const DatePickerField = ({ ...props }) => {
  const { setFieldValue } = useFormikContext();
  const [field] = useField(props);
  return (
    <DatePicker
      {...field}
      {...props}
      selected={(field.value && new Date(field.value)) || null}
      onChange={(val) => {
        setFieldValue(field.name, val);
      }}
    />
  );
};

const EventCreateForm = () => {

  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(getGameFromApi())
  }, [dispatch]);



  const { gameSaved } = useSelector(state => state.event);

  const handleSubmit = (initialValues) => {
    console.log(initialValues);
    dispatch(addEvent(initialValues))
  }

  return (
    <Formik
    initialValues={{title: "", localisation: "", event: "", game: "", plan: "", date: ""}}onSubmit={handleSubmit}
    validationSchema={validationSchema}
    >
      {props => {const {touched,errors,isSubmitting,handleSubmit} = props;
      return (

      <Form onSubmit={handleSubmit} className="event-form-container">

        <div className="event-form">

          <div className='event-form__head'>
            <h1 className="event-form__title">Ajout d'un évènement</h1>
            <NavLink to="/" >
              <button className='event-form__home-button'>
                Dashboard
              </button>
            </NavLink>
          </div>

          <div className='event-form__group__container'>
            <div className="event-form__group event-form__group__container--desktop">
              <label htmlFor="title" className="event-form__group__title">Titre de l'événement</label>
              <Field
                id="title"
                className={classNames({
                  "form-control": true,
                  "is-valid": touched.title && !errors.title,
                  "is-invalid": touched.title && errors.title
                })}
                type="string"
                name="title"
                placeholder="Choisissez un titre"
              />
              {touched.title && errors.title && (
                <div className="invalid-feedback">{errors.title}</div>
              )}
            </div>

            <div className="event-form__group event-form__group__container--desktop">
              <label htmlFor="localisation" className="event-form__group__title">Lieu de l'événement</label>
              <Field
                id="localisation"
                className={classNames({
                  "form-control": true,
                  "is-valid": touched.localisation && !errors.localisation,
                  "is-invalid": touched.localisation && errors.localisation
                })}
                type="string"
                name="localisation"
                as="select"
              >
                <option selected disabled value="">--Selectionne ton departement--</option>
                {
                  departements.map((departement) => (
                    <option value={departement.num_dep} >[{departement.num_dep}] {departement.dep_name}</option>
                  ))
                }
              </Field>
              {touched.localisation && errors.localisation && (
                <div className="invalid-feedback">{errors.localisation}</div>
              )}
            </div>
          </div>

          <div className="event-form__group">
            <label htmlFor="event" className="event-form__group__title">Description de l'événement</label>
            <Field
              component="textarea"
              id="event"
              className={classNames({
                "form-control": true,
                "is-valid": touched.event && !errors.event,
                "is-invalid": touched.event && errors.event
              })}
              type="string"
              name="event"
              placeholder="Décrivez en quelques lignes votre événement"
            />
            {touched.event && errors.event && (
              <div className="invalid-feedback">{errors.event}</div>
            )}
            
          </div>

          <div className="event-form__group">
            <label htmlFor="game" className="event-form__group__title">Selectionne ton jeu</label>
            <Field
              id="game"
              className={classNames({
                "form-control": true,
                "is-valid": touched.game && !errors.game,
                "is-invalid": touched.game && errors.game
              })}
              as="select"
              name="game"
            >
              <option selected disabled value="">--Choisis ton jeu--</option>
              {
                gameSaved.map((game) => (
                  <option key={game.id} value={game.id} >{game.name}</option>
                ))
              }
            </Field>
            {touched.game && errors.game && (
              <div className="invalid-feedback">{errors.game}</div>
            )}
            
          </div>

          <div className="event-form__group">
          <label htmlFor="area" className="event-form__group__title">Nombre de participants</label>
            <Field id="plan" className="event-form__group__select" component="select" name="plan">
              <option selected disabled value="" >--Nombre de participants--</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
            </Field>
          </div>

          <div className="event-form__calendar-container">
            <h2 className='event-form__group__title'>Date de l'évènement</h2>
            <DatePickerField name="date" />
          </div>

          {isSubmitting && <p className='event-form__success'>Votre évènement a bien été ajouté</p>}

          <button type="submit" className="event-form__button-submit" disabled={isSubmitting}>
            Ajouter l'événement
          </button>
        </div>
      </Form>

      )}}
    </Formik>
  )};


  


export default EventCreateForm;