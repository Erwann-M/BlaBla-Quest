import Footer from "../../Components/Footer"
import Header from "../../Components/Header"
import HomeDescription from "../../Components/HomeDescription"
import HomeGrid from "../../Components/HomeGrid"
import Map from "../../Components/Map"
import './styles.scss'

const Home = () => {
    return (
        <div className="homePage">
            <Header />
                <div className="container">
                    <div className="container__background">
                        <div className="container__map">
                            <Map />
                            <HomeDescription />
                        </div>
                    </div>
                    <HomeGrid />
                </div>
            <Footer />
        </div>
    )    
}

export default Home;
