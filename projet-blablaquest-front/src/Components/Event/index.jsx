import LocationIcon from "@mui/icons-material/LocationOn";
import "./styles.scss"
import { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { addEventParticipation, deleteComment, getEventByIdFromApi, getEventParticipation } from "../../action/event";
import { useParams } from "react-router-dom";
import moment from "moment";
import { convertNumberToDepartement } from "../../selector";
import departements from "../../departements";
import CommentForm from "./CommentForm";
import EntrantList from "./EntrantList";
import DeleteForeverIcon  from "@mui/icons-material/DeleteForever";
import WaitList from "./WaitList";
import { toggleLoginForm } from "../../action/user";
import defaultImg from "../../assets/img/default.jpg";

const isUserInWaitlist = (userId, waitlist) => {
    if(!waitlist)
        return;
    return waitlist.find((entry => {
       return entry.user.id === userId && !entry.isValidated && !entry.isRefused 
    }))
}

const isUserValidated = (userId, waitlist) => {
    if(!waitlist) 
        return;
    return waitlist.find(entry => {
        return entry.user.id === userId && entry.isValidated
    })
}

const Event = () => {

    const dispatch = useDispatch();
    const eventId = useParams().slug    
    const event = useSelector((state) => state.event.currentEvent)
    const loaded = useSelector((state) => state.event.currentEventLoaded)
    const participationList = useSelector((state) => state.event.currentEventParticipation)
    const { currentUser, logged } = useSelector(state => state.user)
    const {loadedParticipation, isPendingRequest} = useSelector(state => state.event)
    console.log(event)
    console.log({participationList});

    
    
    useEffect(() => {
        dispatch(getEventByIdFromApi(eventId))
    }, [dispatch, eventId])

    useEffect(() => {
            dispatch(getEventParticipation(eventId));
    }, [dispatch, eventId])

    return (

        <>
        { loaded && 
            <div className="event__container">

                <div className="event__container__main">


                    <div className="event__container__details">
                        
                        <h1 className="event__container__details--title">{event.name}</h1>
                        <img className="event__container__details--image" src={event.game.picture} alt={event.game.name} />
                        <p className="event__container__details--date">le {moment(event.dateTime).format("DD/MM/YYYY")}</p>

                        <div className="event__container__details--location">
                            <LocationIcon />
                            <span className="event__container__details--location-area">{convertNumberToDepartement(departements, event.area).dep_name}</span>
                        </div>

                        <div className="event__container__details--game-info">
                            <p className="event__container__details--description-game">Jeu: <span>{event.game.name}</span></p>
                            <p className="event__container__details--description-game">Age conseillé: <span>{event.game.ageMin} ans</span></p>
                            <p className="event__container__details--description-game">Joueurs max: <span>{event.game.playersMax}</span></p>
                            <p className="event__container__details--description-game">Joueurs min: <span>{event.game.playersMin}</span></p>
                            <p className="event__container__details--description-game">Durée moyenne: <span>{event.game.playtime}</span></p>
                        </div>

                        <h2 className="event__container__details--description-title">Déscription de l'événement :</h2>
                        <p className="event__container__details--description-content">{event.description}</p>
                        <h2 className="event__container__details--description-title">Déscription du jeu :</h2>
                        <p className="event__container__details--description-content">{event.game.description}</p>
                           
                        {loadedParticipation &&

                        currentUser && currentUser.id === event.user.id && 
                            <EntrantList participations={participationList.participations} />
                        }
                    </div>

                    <div className="event__container__comment">
                        <h2 className="event__container__comment--title">Derniers commentaires :</h2>
                        {
                            event.comments.map((comment) => (
                                <div key={comment.id} className="event__container__comment__box">
                                    <div className="event__container__comment__box__user">
                                        <img alt="profil" src={defaultImg} className="event__container__comment__box__user-picture"/>
                                        <span className="event__container__comment__box__user-pseudo">{comment.user.nickname}</span>
                                    </div>
                                    <p className="event__container__comment__box--date">Le {moment(comment.createdAt).format("DD/MM/YYYY à hh:mm")}</p>
                                    <p className="event__container__comment__box--content">{comment.content}</p>
                                    <div className="event__container__comment__box__button">

                                        {  currentUser.id === comment.user.id &&
                                            <button onClick={() => {
                                                dispatch(deleteComment(comment.id))
                                            }} className="event__container__comment__box__button--delete">
                                                <DeleteForeverIcon style={{width: "32px", height: "32px"}} />
                                            </button>

                                        }

                                    </div>
                                </div>
                            ))
                        }
                        <h2 className="event__container__comment--title">Ajoute un commentaire :</h2>
                        {
                            currentUser && currentUser.id ?
                            <CommentForm /> : <p className="event__container__comment--connect">Veuillez vous connecter/inscrire pour commenter</p>
                        }
                    </div>

                </div>


                <div className="aside__container">


                        <div className="aside__container__organizer">
                            <h2 className="aside__container__organizer--title">Organisateur</h2>
                            <img alt="organizer" src={defaultImg} className="aside__container__organizer--picture"/>
                            <h3 className="aside__container__organizer--pseudo">{event.user.nickname}</h3>
                            <div className="aside__container__organizer--location">
                                <LocationIcon />
                                <span>{convertNumberToDepartement(departements, event.area).dep_name}</span>
                            </div>
                        </div>


                        <div className="aside__container__waiting-list">
                            <p className="event__container__details--description-game">Jeu: <span>{event.game.name}</span></p>
                            <p className="event__container__details--description-game">Age conseillé: <span>{event.game.ageMin} ans</span></p>
                            <p className="event__container__details--description-game">Joueurs max: <span>{event.game.playersMax}</span></p>
                            <p className="event__container__details--description-game">Joueurs min: <span>{event.game.playersMin}</span></p>
                            <p className="event__container__details--description-game">Durée moyenne: <span>{event.game.playtime}</span></p>
                        </div>
                       
                        {
                            event.entrantsNumbers !== event.totalUsersValidated && 
                            
                            <div>
                            { 
                
                            (currentUser.id !== event.user.id)  && !isUserInWaitlist(currentUser.id,participationList.participations) 
                            && !isUserValidated(currentUser.id,participationList.participations)
                            &&  !isPendingRequest && 

                                <button onClick={() => {
                                    console.log(eventId)
                                    console.log(currentUser.id)
                                    if(logged) {

                                        dispatch(addEventParticipation(eventId, currentUser.id))
                                    }
                                    else {
                                        dispatch(toggleLoginForm())
                                    }

                                }}>
                                    Rejoindre
                                </button>
                            }
                            {
                                (currentUser.id !== event.user.id)  && 
                                isUserInWaitlist(currentUser.id,participationList.participations) &&

                                <button disabled >
                                    En attente 
                                </button>
                            }
                            {

                                (currentUser.id !== event.user.id)  && isUserValidated(currentUser.id,participationList.participations) &&

                                <button disabled >
                                    Inscrit 
                                </button>
                            }
                            {loadedParticipation &&
                                // bouton a mettre en forme, je ne peut pas voir la page detail quand user connecté.
                            currentUser && currentUser.id === event.user.id && 
                                <WaitList participations={participationList.participations} eventId={eventId} />
                            }
                            </div>
                        }
                </div>
            </div>
        }
        </>
    )
}

export default Event;