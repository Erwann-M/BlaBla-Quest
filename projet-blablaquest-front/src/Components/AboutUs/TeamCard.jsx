import './styles.scss';
import LinkedInIcon from '@mui/icons-material/LinkedIn';
import GitHubIcon from '@mui/icons-material/GitHub';

export default function TeamCard({ image, name, work, linkedin, github, description }) {
  return (

    <div className="team-card">
      <img src={image} alt="team" />
      <div className="team-details">
        <p className="t-title">{name}</p>
        <p className="t-work">{work}</p>
        <p className={description}>{description}</p>
      </div>
      <div className="team-social-icons">
        <a href={linkedin} className='icons'><LinkedInIcon fontSize='large' /></a>
        <a href={github} className='icons'><GitHubIcon fontSize='large' /></a>
      </div>
    </div>
  );
}