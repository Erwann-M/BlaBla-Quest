import './styles.scss';
import EditIcon from '@mui/icons-material/Edit';
import DashboardMap from './DashboardMap';
import { useSelector } from 'react-redux';
import ProgressBar from '../ProgressBar'
import { NavLink } from 'react-router-dom';
import departements from '../../departements';
import { useEffect } from 'react';
import { useDispatch } from 'react-redux';
import { getEventByArea, getEventFollowByUser, getEventHomePageFromApi } from '../../action/event';
import moment from 'moment';
import { convertNumberToDepartement } from '../../selector';

const DashBoard = () => {
  const { eventSaved, eventsHome, eventByArea, mapArea, eventSavedLoaded } = useSelector(state => state.event);

  const { currentUser } = useSelector((state) => state.user);

  const dispatch = useDispatch();

  const userID = currentUser.id;

  useEffect(() => {
    dispatch(getEventFollowByUser(userID))
  }, [dispatch, userID]);

  useEffect(
    () => {
      dispatch(getEventHomePageFromApi())
    }, [dispatch]
  );

  useEffect(
    () => {
      dispatch(getEventByArea(mapArea))
    }, [dispatch, mapArea]
  );

  const handleChange = ((event) => {
    console.log(event.target.value);
    dispatch(getEventByArea(event.target.value))
  })

  const events = eventByArea.length > 0 ? eventByArea : eventsHome;

  console.log(eventByArea)
  console.log(eventSaved);

  console.log(events)

  return (
    <div className="dashboard">
        <div className="dashboard__main">
          <div className="main__event-saved">
            <h1 className="dashboard__main__title">Tableau de bord</h1>
            <h2 className="dashboard__main__subtitle">Mes événements en tant que participant</h2>
            {eventSavedLoaded && 
              eventSaved.participations.map(event => (
                <NavLink to={`/event/${event.event.id}`}>
                  <div key={event.id} className="event-saved">
                    <div className="event-saved__detail">

                      <div className="event-saved__head">
                        <h3 className="event-saved__title">{event.event.name}</h3>
                      </div>

                      <div className="event-saved__info">
                        <p>Participants: {event.event.totalUsersValidated}/{event.event.entrantsNumbers} </p>
                        <div className="event-saved__progress">
                          <ProgressBar nbrOfPlayers={event.event.totalUsersValidated} nbrOfPlayersMax={event.event.entrantsNumbers} />
                        </div>
                      </div>
                    </div>

                    <div className="event-saved__footer">
                      <p className="event-saved__date">Le {moment(event.event.dateTime).format('DD/MM/YYYY')}</p>
                      <p className="event-saved__location">À {convertNumberToDepartement(departements, event.event.area).dep_name}</p>
                    </div>
                  </div>

                </NavLink>
              ))
            }
          </div>

          <div className="main__event-created">
            <div className="main__event-created__add-event">
              <h2 className="dashboard__main__subtitle">Mes événements en tant qu'organisateur</h2>
              <NavLink to="/create" >
                <button className="event-created__button-add">Créer un événement</button>
              </NavLink>
            </div>
            {eventSavedLoaded &&
              eventSaved.eventsCreated.map(event => (
                <NavLink to={`/event/${event.id}`}>
                  <div key={event.id} onClick={() => console.log('eventclick')} className="event-created">
                    <div className="event-created__card">

                      <h3 className="event-created__title">{event.name}</h3>
                      <div className="event-created__detail">
                          <p>Participants: {event.totalUsersValidated}/{event.entrantsNumbers} </p>
                          <div className="event-created__progress">
                            <ProgressBar nbrOfPlayers={event.totalUsersValidated} nbrOfPlayersMax={event.entrantsNumbers} />
                          </div>
                      </div>

                      <div className="event-saved__footer">
                        <div className="event-saved__date">Le {moment(event.dateTime).format('DD/MM/YYYY')}</div>
                        <div className="event-saved__location">{convertNumberToDepartement(departements, event.area).dep_name}</div>
                      </div>

                      {/* <button title="modifier l'évènement" onClick={() => console.log('editbutton')} className="event-created__button-edit">
                        <EditIcon />
                      </button> */}
                    </div>
                  </div>

                </NavLink>

              ))
            }

          </div>
        </div>

        <aside className="dashboard__aside">

          <div className="dashboard__aside__region-container">
            <h2 className="dashboard__main__subtitle aside">Changer de département</h2>
            <div className="dashboard__aside__map">
              <DashboardMap className="dashboard__aside__map-image" />
            </div>

            <select name="region" id="region" className="dashboard__aside__region" onChange={handleChange}>
              <option value="" selected disabled>Choisissez votre département</option>
              {
                departements.map((departement) => (
                  <option value={departement.num_dep}>[{departement.num_dep}] {departement.dep_name}</option>
                ))
              }
            </select>
          </div>

            <h3 className="dashboard__aside__title">Les prochains événements</h3>
            <div className="dashboard__aside__event-container">
              {
                events.map(event => (
                  <NavLink to={`/event/${event.id}`}>
                    <div key={event.id} className="dashboard__aside__comming-event">
                      <h2 className="comming-event__title">{event.game.name}</h2>
                      <div className="comming-event__info">
                        <p>{convertNumberToDepartement(departements, event.area).dep_name}</p>
                        <p>Le {moment(event.dateTime).format('DD/MM/YYYY')}</p>
                      </div>

                    {/* <button className="dashboard__aside__join-button">Rejoindre</button> */}
                    </div>
                  </NavLink>
                ))
              }
            </div>
        </aside>
    </div>
  )
}

export default DashBoard;