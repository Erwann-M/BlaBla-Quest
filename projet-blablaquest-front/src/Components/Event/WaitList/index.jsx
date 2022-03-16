import { useDispatch } from 'react-redux';
import { refuseUserParticipation, validateUserParticipation } from '../../../action/event';
import './styles.scss'


const WaitList = ({participations, eventId}) => {
    const dispatch= useDispatch();
    console.log(eventId);
    

    return (
        <div className="waitlist__content">
            <h2 className="waitlist__content--title" >Demandes de participation:</h2>
                {
                   participations.filter((participation) => (participation.isValidated === false && participation.isRefused === false)).map(((participation) => (

                       <div className="waitlist__content--user" key={participation.id}>
                           <p className='waitlist__content--user--title'>{participation.user.nickname}</p>
                           <div className="waitlist__content--user--button">
                            <button className='waitlist__content--user--button--click' onClick={() => {
                                console.log(participation.id);
                                console.log(eventId);
                                dispatch(validateUserParticipation(participation.id, eventId, participation.user.id))
                            }}>+</button>
                            <button className='waitlist__content--user--button--click' onClick={() => {
                                console.log(participation.id);
                                console.log(eventId);
                                dispatch(refuseUserParticipation(participation.id, eventId, participation.user.id))
                            }}>x</button>

                           </div>

                       </div>
                   )))
                }
        </div>
    )
}

export default WaitList;