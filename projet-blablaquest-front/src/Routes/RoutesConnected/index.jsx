import { Routes, Route, Navigate } from "react-router-dom";

import DashBoardPage from "../../Page/DashBoardPage";
import Creation from "../../Page/Creation"
import EventPage from "../../Page/EventDetails";
import TeamPage from "../../Page/Team"
import NotFound from "../../Page/NotFound";

const RoutesConnected = () =>{
    return (
        <Routes>
            <Route exact path="/" element={<DashBoardPage />} />
            <Route exact path="/create" element={ <Creation/> } />
            <Route path="/registration" element={<Navigate to="/" />}/>
            <Route path="/event/:slug" element={ <EventPage/> } />
            <Route path="/team" element={ <TeamPage/> } />
            <Route path="/error" element={ <NotFound/> } />
            <Route path="/*" element={<Navigate to="/error" />}/>
        </Routes>

    )
}

export default RoutesConnected;