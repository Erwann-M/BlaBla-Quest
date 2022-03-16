import Footer from "../../Components/Footer"
import Header from "../../Components/Header"
import EventForm from "../../Components/EventForm"
import './styles.scss'

const Creation = () => {
    return (
        <div className="event-create-page">
            <Header />
            <EventForm />
            <Footer />
        </div>

    )    
}

export default Creation;