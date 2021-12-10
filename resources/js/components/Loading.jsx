import React from "react";

import Loader from "react-loader-spinner";

export default class Loading extends React.Component {
    render() {
        return (
            <div className="d-flex flex-column vh-100 justify-content-center align-items-center">
                <Loader type="ThreeDots" color="#0d6efd"/>
            </div>
        );
    }
}
