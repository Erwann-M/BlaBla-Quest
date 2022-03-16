import { NavLink } from 'react-router-dom';
import './styles.scss';

const Footer = () => (
  <div className="footer">

        <NavLink to="/team">Notre Team</NavLink>
      <div className="footer__social">
        Données récupérées sur <a href="https://www.philibertnet.com/fr/">Philibert</a>
      </div>
  </div>
);

export default Footer;
