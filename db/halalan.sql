--
-- PostgreSQL database dump
--

SET client_encoding = 'UNICODE';
SET check_function_bodies = false;

SET SESSION AUTHORIZATION 'postgres';

SET search_path = public, pg_catalog;

--
-- TOC entry 18 (OID 20628)
-- Name: plpgsql_call_handler(); Type: FUNC PROCEDURAL LANGUAGE; Schema: public; Owner: postgres
--

CREATE FUNCTION plpgsql_call_handler() RETURNS language_handler
    AS '$libdir/plpgsql', 'plpgsql_call_handler'
    LANGUAGE c;


SET SESSION AUTHORIZATION DEFAULT;

--
-- TOC entry 17 (OID 20629)
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: public; Owner: 
--

CREATE TRUSTED PROCEDURAL LANGUAGE plpgsql HANDLER plpgsql_call_handler;


SET SESSION AUTHORIZATION 'postgres';

--
-- TOC entry 4 (OID 2200)
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO PUBLIC;


SET SESSION AUTHORIZATION 'postgres';

--
-- TOC entry 5 (OID 300836)
-- Name: candidates; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE candidates (
    candidateid serial NOT NULL,
    firstname character varying(63) NOT NULL,
    lastname character varying(31) NOT NULL,
    partyid integer NOT NULL,
    positionid integer NOT NULL,
    description text,
    picture character varying(255)
) WITHOUT OIDS;


--
-- TOC entry 6 (OID 300844)
-- Name: parties; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE parties (
    partyid serial NOT NULL,
    party character varying(63) NOT NULL,
    description text,
    logo character varying(255)
) WITHOUT OIDS;


--
-- TOC entry 7 (OID 300852)
-- Name: positions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE positions (
    positionid serial NOT NULL,
    "position" character varying(63) NOT NULL,
    description text,
    maximum smallint NOT NULL,
    ordinality smallint NOT NULL
) WITHOUT OIDS;


--
-- TOC entry 8 (OID 300860)
-- Name: voters; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE voters (
    voterid serial NOT NULL,
    email character varying(63) NOT NULL,
    "password" character(40) NOT NULL,
    pin character varying(40) NOT NULL,
    firstname character varying(63) NOT NULL,
    lastname character varying(31) NOT NULL,
    voted smallint DEFAULT 0 NOT NULL
) WITHOUT OIDS;


--
-- TOC entry 9 (OID 300863)
-- Name: votes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE votes (
    voterid integer NOT NULL,
    candidateid integer NOT NULL,
    timeadded timestamp without time zone DEFAULT now() NOT NULL
) WITHOUT OIDS;


--
-- TOC entry 10 (OID 301179)
-- Name: admins; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE admins (
    adminid serial NOT NULL,
    email character varying(63) NOT NULL,
    "password" character(40) NOT NULL,
    firstname character varying(63) NOT NULL,
    lastname character varying(31) NOT NULL
) WITHOUT OIDS;


--
-- TOC entry 11 (OID 300865)
-- Name: candidates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY candidates
    ADD CONSTRAINT candidates_pkey PRIMARY KEY (candidateid);


--
-- TOC entry 12 (OID 300867)
-- Name: parties_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY parties
    ADD CONSTRAINT parties_pkey PRIMARY KEY (partyid);


--
-- TOC entry 13 (OID 300869)
-- Name: positions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY positions
    ADD CONSTRAINT positions_pkey PRIMARY KEY (positionid);


--
-- TOC entry 14 (OID 300871)
-- Name: voters_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY voters
    ADD CONSTRAINT voters_pkey PRIMARY KEY (voterid);


--
-- TOC entry 15 (OID 300873)
-- Name: votes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY votes
    ADD CONSTRAINT votes_pkey PRIMARY KEY (voterid, candidateid);


--
-- TOC entry 16 (OID 301182)
-- Name: admins_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY admins
    ADD CONSTRAINT admins_pkey PRIMARY KEY (adminid);


--
-- TOC entry 19 (OID 317171)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY candidates
    ADD CONSTRAINT "$1" FOREIGN KEY (partyid) REFERENCES parties(partyid) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 20 (OID 317175)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY candidates
    ADD CONSTRAINT "$2" FOREIGN KEY (positionid) REFERENCES positions(positionid) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 21 (OID 317179)
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY votes
    ADD CONSTRAINT "$1" FOREIGN KEY (voterid) REFERENCES voters(voterid) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 22 (OID 317183)
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY votes
    ADD CONSTRAINT "$2" FOREIGN KEY (candidateid) REFERENCES candidates(candidateid) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 3 (OID 2200)
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'Standard public schema';


