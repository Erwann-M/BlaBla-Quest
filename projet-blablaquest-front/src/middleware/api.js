import axios from "axios";
import moment from "moment";
import { addValidateUser, ADD_COMMENT_ON_EVENT, ADD_EVENT_PARTICIPATION, ADD_EVENT, GET_GAME_FROM_API, currentEventUpdateComments, deleteRefusedUser, DELETE_COMMENT, GET_EVENT_BY_AREA, GET_EVENT_BY_ID_FROM_API, GET_EVENT_FOLLOW_BY_USER, GET_EVENT_HOME_PAGE_FROM_API, GET_EVENT_PARTICIPATION, REFUSE_USER_PARTICIPATION, saveCurrentEvent, saveEventByArea, saveEvent, saveEventFollowByUser, saveGameFromApi, saveEventParticipation, updateCommentsDeleted, updateEventParticipation, VALIDATE_USER_PARTICIPATION } from "../action/event";
import {saveEventsHomePage} from "../action/event"
import { LOGIN, setCurrentUser, setErrorLogin, REGISTER , login} from "../action/user";
const axiosInstance = axios.create({
    baseURL: "http://15.188.23.49/api/v1"
})

const apiMiddleware = (store) => (next) => (action) => {
    switch(action.type) {
        case GET_EVENT_HOME_PAGE_FROM_API:
            axiosInstance.get('/event')
                .then((res) => {
                    store.dispatch(saveEventsHomePage(res.data));
                })
                .catch((err) => {
                    console.log(err);
                })
            next(action);
            break;
        case GET_EVENT_BY_AREA: 
            axiosInstance.get(`/event/area/${action.area}`)
                .then((res) => {
                    store.dispatch(saveEventByArea(res.data));
                })
                .catch((err) => console.log(err))
            next(action);
            break;
        case LOGIN:
            const {email, password} = action.values
            axiosInstance.post('/login_check', {
                username: email,
                password,
            })
                .then((res) => {
                    console.log(res.data);
                    store.dispatch(setCurrentUser(res.data));
                })
                .catch((err) => {
                    console.log(err);
                    store.dispatch(setErrorLogin())
                });
            next(action);
            break;
        case REGISTER:
            const mail = action.values.email
            const pass = action.values.password
            const nickname = action.values.nickname
            const area = action.values.area
            axiosInstance.post('/user/registration', {
                email: mail,
                password: pass,
                nickname,
                area,
            })
                .then((res) => {
                    const user = {email: mail, password: pass}
                    store.dispatch(login(user))
                    console.log(res.data);
                    
                })
                .catch((err) => {console.log(err);})
                next(action);
            break;    
        case GET_EVENT_BY_ID_FROM_API:
            axiosInstance.get(`/event/${action.id}`)
                .then((res) => {  
                    store.dispatch(saveCurrentEvent(res.data))

                })
                .catch((err) => console.log(err));
                next(action)
                break;
        case GET_EVENT_FOLLOW_BY_USER:
            axiosInstance.get(`/user/${action.userID}/event`)
                .then((res) => {
                    store.dispatch(saveEventFollowByUser(res.data))
                    
                })
                .catch((err) => console.log(err));
                next(action)
                break;
        case GET_GAME_FROM_API:
            axiosInstance.get(`/game`)
                .then((res) => {
                    store.dispatch(saveGameFromApi(res.data))
                })
                .catch((err) => console.log(err));
                next(action)
                break;
        case ADD_EVENT: 
            const {token} = store.getState().user;
            const {title, localisation, event, game, plan } = action.event;
            const date = moment(action.event.date).format('YYYY-MM-DD')
            axiosInstance.post("/event", {
                name: title,
                description: event,
                area: localisation,
                game: game,
                entrantsNumbers: plan,
                dateTime: date,
            }, {
                headers: {
                    "Authorization": `Bearer ${token}`,
                }
            })
            .then((res) => {
                store.dispatch(saveEvent(res.data))
            })
            .catch((err) => console.log(err));
            next(action)
            break;
        case ADD_COMMENT_ON_EVENT: 
            const token1  = store.getState().user.token
            console.log(token1);
            axiosInstance.post(`/event/${action.values.eventId}/comment`, {
                content: action.values.comment
            }, {
                headers: {
                    "Authorization": `Bearer ${token1} `,
     
                }
            })
                .then(res => {
                    console.log(res);
                    store.dispatch(currentEventUpdateComments(res.data))
                })
                .catch((err) => console.log(err))
                next(action)
                break;
        case DELETE_COMMENT:
            const tokenUser  = store.getState().user.token
            axiosInstance.delete(`/event/comment/${action.commentId}`,
            {
                headers: {
                    "Authorization": `Bearer ${tokenUser} `,
                }
            }
            )
                .then((res) => {
                    store.dispatch(updateCommentsDeleted(action.commentId))
                })
                .catch((err) => console.log(err))
                next(action)
                break;
        case ADD_EVENT_PARTICIPATION: 
                const tokenParticipation  = store.getState().user.token
                axiosInstance.post(`/participation/${action.eventId}`, {
                    user: action.userId,
                    event: action.eventId
                }, {
                    headers: {
                        "Authorization": `Bearer ${tokenParticipation} `,
                    }
                })
                    .then((res) => {
                        console.log(res);
                        store.dispatch(updateEventParticipation(action.userId))
                    })
                    .catch((err) => console.log(err))
                next(action);
                break;
        case GET_EVENT_PARTICIPATION: 
            const newToken  = store.getState().user.token
                axiosInstance.get(`/event/${action.eventId}/participation`, {
                    headers: {
                        'Authorization': `Bearer ${newToken}`
                    }
                })
                    .then((res) => {
                        console.log(res.data);
                        store.dispatch(saveEventParticipation(res.data));
                    })
                    .catch((err) => console.log(err))
                next(action);
                break;
        case VALIDATE_USER_PARTICIPATION: 
            const tokenValidate = store.getState().user.token
            console.log(action.participationId);
            console.log(action.eventId);
            console.log(tokenValidate);

            axiosInstance.put(`/participation/${action.participationId}/validate/${action.eventId}`,{} ,{
                headers: {
                    'Authorization': `Bearer ${tokenValidate}`
                }
            })
                .then((res) => {
                    console.log(res.data);
                    store.dispatch(addValidateUser(action.userId))
                })
                .catch((err) => console.log(err))

            next(action);
            break;
        case REFUSE_USER_PARTICIPATION:
            const tokenRefuse = store.getState().user.token
            console.log(action.userId);

            axiosInstance.put(`/participation/${action.participationId}/refuse/${action.eventId}`, {}, {
                headers: {
                    'Authorization': `Bearer ${tokenRefuse}`
                }
            })
                .then((res) => {
                    console.log(res.data);
                    store.dispatch(deleteRefusedUser(action.userId))
                    
                })
                .catch((err) => console.log(err))
            next(action);
            break;
        default:

            next(action)        
    }
}
export default apiMiddleware;