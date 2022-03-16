import { Field, Form, withFormik, Formik } from 'formik';
import classNames from "classnames";
import * as Yup from 'yup';
import './styles.scss';
import { useDispatch } from 'react-redux';
import { addCommentOnEvent } from '../../../action/event';
import { useParams } from 'react-router';

const CommentCreateForm = ({ values, errors, touched, isSubmitting }) => {

  const dispatch = useDispatch();
  const eventId = useParams().slug

  const handleSubmit = (initialValues, {resetForm}) => {
    console.log(initialValues);
    dispatch(addCommentOnEvent(initialValues))
    resetForm({initialValues})

  }

  return (
    <Formik 
    initialValues={{ comment: "", eventId: eventId }}
    onSubmit={handleSubmit}
    enableReinitialize={true}
    
    >
  
  {props => {const {values,touched,errors,handleSubmit} = props;
  return (
    <Form onSubmit={handleSubmit} className="comment-form">
       <div className="comment-form__group">
          <Field
            component="textarea"
            id="event"
            className={classNames({
              "form-control": true,
              "is-valid": touched.comment && !errors.comment,
              "is-invalid": touched.comment && errors.comment
            })}
            type="string"
            name="comment"
            placeholder="Écrit ton commentaire"
          />
          {touched.comment && errors.comment && (
            <div className="invalid-feedback">{errors.comment}</div>
          )}
          
        </div>
        <button type="submit" className="comment-form__button-submit" disabled={isSubmitting}>
          Envoyer
        </button>
    </Form>
    );
  }}
</Formik>
)};

const CommentForm = withFormik({
  mapPropsToValues({ comment }) {
    return {
      comment: comment || "",
    };
  },
  validationSchema: Yup.object().shape({
    comment: Yup.string()
  })}
)(CommentCreateForm);

export default CommentForm;
