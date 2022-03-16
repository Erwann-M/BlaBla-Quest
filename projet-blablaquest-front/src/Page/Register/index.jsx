import Footer from "../../Components/Footer"
import Header from "../../Components/Header"
import FormikForm from "../../Components/FormikForm"
import './styles.scss'

const Registration = () => {
    return (
        <div className="registration-page">
            <Header />
            <FormikForm />
            <Footer />
        </div>
    )
}

export default Registration;