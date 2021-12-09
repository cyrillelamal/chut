import React from "react";
import ParticipationPreview from "./ParticipationPreview";
import {getLatestParticipations} from "../../services/participations";

export default class ParticipationList extends React.Component {
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
            console.log(this)
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
            <div className="h-100 d-flex flex-column p-4">
                <div className="flex-grow-1 overflow-auto p-3 mt-3" onScroll={this.handleScroll}>
                    {this.state.participations.map(this.preview)}
                </div>
            </div>
        );
    }
}
