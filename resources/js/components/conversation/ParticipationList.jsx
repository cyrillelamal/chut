import React from "react";
import Authenticated from "../security/Authenticated";
import {getLatestParticipations} from "../../services/participations";

export default class ParticipationList extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            participations: [],
            page: 1,
        };
    }

    componentDidMount() {
        getLatestParticipations(this.state.page).then(({data: participations}) => {
            this.setState({participations});
        });
    }

    render() {
        // TODO: impl
        return (
            <Authenticated>
                <div className="container py-5">
                    {this.state.participations.map(p => (
                        <p key={p.id}>
                            {p.visible_title}
                        </p>
                    ))}
                </div>
            </Authenticated>
        );
    }
}
