import './styles.scss';
import DashBoard from '../../Components/DashBoard';
import Header from '../../Components/Header';
import Footer from '../../Components/Footer'

const DashBoardPage = () => {
    return (
        <div className="dashboard-page">
            <Header />
            <DashBoard />
            <Footer />
        </div>

    )
}

export default DashBoardPage;