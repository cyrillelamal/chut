import React from "react";
import ParticipationPreview from "./ParticipationPreview";
import {getLatestParticipations} from "../../services/participations";

export default class ParticipationList extends React.Component {
    static STYLE = {
        maxHeight: '75vh',
    }

    constructor(props) {
        super(props);
        this.state = {
            participations: [],
            page: 1,
            last_page: null,
        };
    }

    componentDidMount() {
        getLatestParticipations(1)
            .then(
                ({data, meta}) => this.setState({participations: data, last_page: meta.last_page})
            );
    }

    handleScroll = (e) => {
        const {scrollHeight, scrollTop, clientHeight} = e.target;

        if (clientHeight === scrollHeight - scrollTop) { // bottom
            this.setState(
                (state) => {
                    const {page, last_page} = state;

                    if (last_page <= page) {
                        return {page: last_page};
                    }

                    getLatestParticipations(page + 1)
                        .then(
                            ({data}) => this.setState(
                                (state) => ({participations: [...state.participations, ...data]})
                            )
                        );

                    return {page: page + 1};
                }
            );
        }
    }

    preview = (p) => <ParticipationPreview key={p.id} {...p}/>;

    render() {
        return (
            <div className="p-4 overflow-auto" style={ParticipationList.STYLE} onScroll={this.handleScroll}>
                {this.state.participations.map(this.preview)}
            </div>
        );
    }
}
