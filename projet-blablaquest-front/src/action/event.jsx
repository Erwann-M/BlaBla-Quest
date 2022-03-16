export const GET_EVENT_HOME_PAGE_FROM_API = "GET_EVENT_HOME_PAGE_FROM_API";

export const getEventHomePageFromApi = () => ({
    type: GET_EVENT_HOME_PAGE_FROM_API,
});


export const GET_EVENT_BY_ID_FROM_API = "GET_EVENT_BY_ID_FROM_API";

export const getEventByIdFromApi = (id) => ({
    type: GET_EVENT_BY_ID_FROM_API,
    id
});

export const SAVE_CURRENT_EVENT = "SAVE_CURRENT_EVENT";

export const saveCurrentEvent = (event) => ({
    type: SAVE_CURRENT_EVENT,
    event
})


export const SAVE_EVENTS_HOME_PAGE = "SAVE_EVENTS_HOME_PAGE"

export const saveEventsHomePage = (events) => ({
    type: SAVE_EVENTS_HOME_PAGE,
    events
});

export const GET_EVENT_BY_AREA = "GET_EVENT_BY_AREA";

export const getEventByArea = (area) => ({
    type: GET_EVENT_BY_AREA,
    area
});

export const SAVE_EVENT_BY_AREA = "SAVE_EVENT_BY_AREA"

export const saveEventByArea = (events) => ({
    type: SAVE_EVENT_BY_AREA,
    events
});

export const SET_AREA_MAP = "SET_AREA_MAP"

export const setAreaMap = (mapArea) => ({
    type: SET_AREA_MAP,
    mapArea
});

export const GET_EVENT_FOLLOW_BY_USER = "GET_EVENT_FOLLOW_BY_USER";

export const getEventFollowByUser = (userID) => ({
    type: GET_EVENT_FOLLOW_BY_USER,
    userID
});

export const SAVE_EVENT_FOLLOW_BY_USER = "SAVE_EVENT_FOLLOW_BY_USER"

export const saveEventFollowByUser = (events) => ({
    type: SAVE_EVENT_FOLLOW_BY_USER,
    events
});

export const GET_GAME_FROM_API = "GET_GAME_FROM_API"

export const getGameFromApi = () => ({
    type: GET_GAME_FROM_API,
});

export const SAVE_GAME_FROM_API = "SAVE_GAME_FROM_API"

export const saveGameFromApi = (game) => ({
    type: SAVE_GAME_FROM_API,
    game
});

export const ADD_EVENT = "ADD_EVENT"

export const addEvent = (event) => ({
    type: ADD_EVENT,
    event
});

export const SAVE_EVENT = "SAVE_EVENT"

export const saveEvent = (event) => ({
    type: SAVE_EVENT,
    event
});

export const ADD_COMMENT_ON_EVENT = "ADD_COMMENT_ON_EVENT";

export const addCommentOnEvent = (values) => ({
    type: ADD_COMMENT_ON_EVENT,
    values
})

export const CURRENT_EVENT_UPDATE_COMMENTS = "CURRENT_EVENT_UPDATE_COMMENTS";

export const currentEventUpdateComments = (values) => ({
    type: CURRENT_EVENT_UPDATE_COMMENTS,
    values
})

export const DELETE_COMMENT = "DELETE_COMMENT";

export const deleteComment = (commentId) => ({
    type: DELETE_COMMENT,
    commentId
})

export const UPDATE_COMMENTS_DELETED = "UPDATE_COMMENTS_DELETED";

export const updateCommentsDeleted = (commentId) => ({
    type: UPDATE_COMMENTS_DELETED,
    commentId
})

export const ADD_EVENT_PARTICIPATION = "ADD_EVENT_PARTICIPATION";

export const addEventParticipation = (eventId, userId) => ({
    type: ADD_EVENT_PARTICIPATION,
    eventId,
    userId
})


export const  GET_EVENT_PARTICIPATION = "GET_EVENT_PARTICIPATION";

export const getEventParticipation = (eventId) => ({
    type: GET_EVENT_PARTICIPATION,
    eventId,
})

export const  SAVE_EVENT_PARTICIPATION = "SAVE_EVENT_PARTICIPATION";

export const saveEventParticipation = (eventParticipation) => ({
    type: SAVE_EVENT_PARTICIPATION,
    eventParticipation,
})

export const SET_USER_JOIN_PENDING = "SET_USER_JOIN_PENDING";

export const setUserJoinPending = () => ({
    type: SET_USER_JOIN_PENDING,
})


export const UPDATE_EVENT_PARTICIPATION = "UPDATE_EVENT_PARTICIPATION";

export const updateEventParticipation = (userId) => ({
    type: UPDATE_EVENT_PARTICIPATION,
    userId
})

export const VALIDATE_USER_PARTICIPATION = "VALIDATE_USER_PARTICIPATION";

export const validateUserParticipation = (participationId, eventId, userId) => ({
    type: VALIDATE_USER_PARTICIPATION,
    participationId,
    eventId,
    userId
})

export const ADD_VALIDATE_USER = "ADD_VALIDATE_USER";

export const addValidateUser = (userId) => ({
    type: ADD_VALIDATE_USER,
    userId
})

export const REFUSE_USER_PARTICIPATION = "REFUSE_USER_PARTICIPATION";


export const refuseUserParticipation = (participationId, eventId, userId) => ({
    type: REFUSE_USER_PARTICIPATION,
    participationId,
    eventId,
    userId
})

export const DELETE_REFUSED_USER = "DELETE_REFUSED_USER";

export const deleteRefusedUser = (userId) => ({
    type: DELETE_REFUSED_USER,
    userId
})

