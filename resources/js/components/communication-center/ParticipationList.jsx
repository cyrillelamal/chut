import React from "react";
import ParticipationPreview from "./ParticipationPreview";
import {getLatestParticipations} from "../../services/participations";
import {bottom, demandNewPage} from "../../services/pagination";
import Participation from "../../models/Participation";
import LatestNotificationContext from "../notification/LatestNotificationContext";

export default class ParticipationList extends React.Component {
    constructor(props, context) {
        super(props, context);
        this.state = {
            participations: [],
            page: 1,
            last_page: null,
        };

        this.previous = this.context;
    }

    componentDidMount() {
        getLatestParticipations(1)
            .then(({data, meta}) => {
                const participations = data.map(p => new Participation(p));
                return {participations, last_page: meta.last_page};
            })
            .then(this.setState.bind(this));
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        if (this.previous === this.context) {
            return;
        }

        this.previous = this.context;

        this.setState(state => {
            const newest = Participation.buildFromNotification(this.context);
            const bumped = state.participations.find(newest.isSame);

            if (bumped) {
                const intact = state.participations.filter(p => !newest.isSame(p));
                return {participations: [newest, ...intact]};
            }

            return {participations: [newest, ...state.participations]};
        });
    }

    handleScroll = ({target}) => {
        if (bottom(target)) { // bottom
            this.setState(
                (state) => {
                    const {page, last_page} = state;

                    const nextPage = demandNewPage(
                        page, last_page,
                        () => getLatestParticipations(page + 1)
                            .then(({data}) => {
                                const participations = data.map(p => new Participation(p));
                                this.appendParticipations(participations);
                            })
                    );

                    return {page: nextPage};
                }
            );
        }
    }

    appendParticipations = (participations) => {
        this.setState(state => ({participations: [...state.participations, ...participations]}));
    }

    preview = (p) => <ParticipationPreview key={p.key} participation={p} uid={p.key}/>;

    render() {
        return (
            <div className="h-100 d-flex flex-column p-4">
                <div className="flex-grow-1 overflow-auto p-3 mt-3" onScroll={this.handleScroll}>
                    {this.participations.map(this.preview)}
                </div>
            </div>
        );
    }

    /**
     * @return {Participation[]}
     */
    get participations() {
        return this.state.participations;
    }

    /**
     * @return {Notification[]}
     */
    get notifications() {
        return this.context ?? [];
    }
}

ParticipationList.contextType = LatestNotificationContext;
