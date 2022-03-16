import eventCreated from "../eventCreated";
import eventClose from "../eventClose";
import { SAVE_EVENTS_HOME_PAGE, SAVE_EVENT_BY_AREA, SET_AREA_MAP, SAVE_CURRENT_EVENT, SAVE_EVENT_FOLLOW_BY_USER, ADD_COMMENT_ON_EVENT, SAVE_GAME_FROM_API, CURRENT_EVENT_UPDATE_COMMENTS, UPDATE_COMMENTS_DELETED, SAVE_EVENT_PARTICIPATION, UPDATE_EVENT_PARTICIPATION, ADD_VALIDATE_USER, DELETE_REFUSED_USER, } from "../action/event";

export const initialState = {
    eventsHome: [],
    eventByArea: [],
    eventSaved: [],
    eventSavedLoaded: false,
    gameSaved: [],
    eventCreated: eventCreated,
    eventClose: eventClose,
    mapArea: null,
    currentEvent: [],
    currentEventParticipation: [],
    loadedParticipation: false,
    currentEventLoaded: false,
};

const reducer = (state = initialState, action = {}) => {
    switch (action.type) {
        case SAVE_EVENTS_HOME_PAGE: 
            return {
                ...state,
                eventsHome: action.events
            }
        case SAVE_EVENT_BY_AREA:
            return {
                ...state,
                eventByArea: action.events
            }

        case SET_AREA_MAP:
            return {
                ...state,
                mapArea: action.mapArea
            }
        case SAVE_CURRENT_EVENT:
            return {
                ...state,
                currentEvent: action.event,
                currentEventLoaded: true,
            }
        case SAVE_EVENT_FOLLOW_BY_USER:
            return {
                ...state,
                eventSaved: action.events,
                eventSavedLoaded: true,
            }
        case SAVE_GAME_FROM_API:
            return {
                ...state,
                gameSaved: action.game,
            }
        case CURRENT_EVENT_UPDATE_COMMENTS: 
            return{
                ...state,
                currentEvent: {
                    ...state.currentEvent,
                    comments: [...state.currentEvent.comments, action.values]
                }
            }
        case UPDATE_COMMENTS_DELETED: 
            return {
                ...state,
                currentEvent: {
                    ...state.currentEvent,
                    comments: [ ...state.currentEvent.comments.filter(comment => comment.id !== action.commentId)]
                }
            }
        case SAVE_EVENT_PARTICIPATION:
            return {
                ...state,
                currentEventParticipation: action.eventParticipation,
                loadedParticipation: true,
            }
        case UPDATE_EVENT_PARTICIPATION:
            return {
                ...state,
                currentEventParticipation: {
                    participations: [...state.currentEventParticipation.participations, {isValidated: false, isRefused: false, user: {id: action.userId}}]
                }

            }
        case ADD_VALIDATE_USER: 
            const test = state.currentEventParticipation.participations.find(entry => entry.user.id === action.userId)
            test.isValidated = true


            return {
                ...state,
                currentEventParticipation: {
                    participations:  [...state.currentEventParticipation.participations.filter(entry => entry.user.id !== action.userId), test]
                       
                }
            }
        case DELETE_REFUSED_USER: 
            return {
                ...state,
                currentEventParticipation: {
                    participations: [...state.currentEventParticipation.participations.filter(entry => entry.user.id !== action.userId) ]
                }
            }
        default:
            return state;
    }
};

export default reducer;
