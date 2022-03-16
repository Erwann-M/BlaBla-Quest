import './styles.scss';
//Import icon from @mui
import { useEffect } from 'react';
import { getEventByArea, getEventHomePageFromApi } from '../../action/event';
import { useDispatch, useSelector } from 'react-redux';
import { convertNumberToDepartement } from '../../selector';
import moment from 'moment'
import departements from '../../departements';
import { NavLink } from 'react-router-dom';

const HomeGrid = () => {

  const {eventsHome, eventByArea, mapArea} = useSelector(state => state.event);
  
  const dispatch = useDispatch();
  
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

  const events = eventByArea.length > 0 ? eventByArea : eventsHome;
  console.log(events);
  
    return (
    
    <div className="container-bot">
      <h1 className='container-bot__title'>Liste des événements départementaux</h1>
      <div className="container-bot__main">
        {
          events.slice(0,6).map((event) => (
            <NavLink to={`/event/${event.id}`} >
              {
                console.log(event)
              }
              <div key={event.id} className="container-bot__card">
                <div className='container-bot__card__image-container'>
                  <img className='container-bot__card__image' src={event.game.picture} alt={event.game.name} />
                </div>
                <h2 className='container-bot__card__event-name'>{event.name}</h2>
                <h3 className='container-bot__card__game-name'>{event.game.name}</h3>
                <div className='container-bot__card__info'>
                  <p className='container-bot__card__date'>Le {moment(event.dateTime).format('DD/MM/YYYY')}</p>
                  <p className='container-bot__card__area'>{convertNumberToDepartement(departements, event.area).dep_name}</p>
                </div>
              </div>
            </NavLink>
          ))
        }
      </div>
    </div>
    )
};
export default HomeGrid;