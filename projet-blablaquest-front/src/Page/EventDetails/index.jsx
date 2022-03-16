import Footer from "../../Components/Footer";
import Header from "../../Components/Header";
import Event from "../../Components/Event";
import './styles.scss';

const EventPage = () => {
    return (
        <div className="event-page">
            <Header />
            <Event />
            <Footer />
        </div>
    )
}

export default EventPage;