import TeamCard from "./TeamCard";
import './styles.scss';

const Team = () => {

  return (
    <div className="team-container">
      <div className="team-header">
        <p className="team-title">La Team</p>
        <p className="team-description">
        </p>
      </div>
      <div className="team-cards">
        <TeamCard
          image="https://ca.slack-edge.com/T024XJVRLBC-U026J8S1PCL-99c94176c41b-512"
          name="Jennifer Chaul"
          work="Product Manager"
          description="Back-end"
          linkedin="http://www.linkedin.com/in/jennifer-chaul"
          github="https://github.com/jenniferchaul"
        />
        <TeamCard
          image="https://ca.slack-edge.com/T024XJVRLBC-U0271S4PA0Y-7175b1f393aa-512"
          name="Brice Correia"
          work="Scrum Master"
          description="Back-end"
          linkedin="https://www.linkedin.com/in/brice-correia/"
          github="https://github.com/bricecorreia"
        />
        <TeamCard
          image="https://ca.slack-edge.com/T024XJVRLBC-U026C30ASPL-87cf645d8b90-512"
          name="Erwann Martin"
          work="Git Master"
          description="Front-end"
          linkedin="https://www.linkedin.com/in/erwann-martin-988b21158/"
          github="https://github.com/Erwann-M"
        />
        <TeamCard
          image="https://ca.slack-edge.com/T024XJVRLBC-U0269LGJ8TX-bea8fc689f89-512"
          name="Khaled Abdelhak"
          work="Lead Developer"
          description="Front-end"
          linkedin=""
          github="https://github.com/khaledAbdelhak"
        />
        <TeamCard
          image="https://ca.slack-edge.com/T024XJVRLBC-U025XAJT0TH-bce906d91401-512"
          name="Cédric Trouvé"
          work="Technical Lead"
          description="Front-end"
          linkedin="https://www.linkedin.com/in/c%C3%A9dric-trouv%C3%A9-b7ab42220/"
          github="https://github.com/Cedrictve"
        />
      </div>
    </div>
  );
}



export default Team;