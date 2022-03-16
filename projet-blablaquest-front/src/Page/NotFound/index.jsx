import Footer from "../../Components/Footer"
import Header from "../../Components/Header"
import Error404 from "../../Components/ErrorPage"
import './styles.scss'

const NotFound = () => {
    
    return (
        <div className="registration-page">
            <Header />
            <Error404 />
            <Footer />
        </div>
    )
}

export default NotFound;