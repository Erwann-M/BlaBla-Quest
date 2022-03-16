import Home from '../../Page/Home';
import { Routes, Route, Navigate } from "react-router-dom";
import Registration from '../../Page/Register';
import EventPage from '../../Page/EventDetails';
import TeamPage from '../../Page/Team';
import NotFound from '../../Page/NotFound';



const RoutesDisconnected = () =>{
    return (
        <Routes>
            <Route path="/" element={ <Home/> } />
            <Route path="/registration" element={ <Registration/> } />
            <Route path="/event/:slug" element={ <EventPage/> } />
            <Route path="/create" element={<Navigate to="/" />}/>
            <Route path="/team" element={ <TeamPage/> } />
            <Route path="/error" element={ <NotFound/> } />
            <Route path="/*" element={<Navigate to="/error" />}/>
        </Routes>

    )
}

export default RoutesDisconnected;