--
-- PostgreSQL database dump
--

SET client_encoding = 'UTF8';
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA public IS 'Standard public schema';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: admins; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE admins (
    adminid serial NOT NULL,
    email character varying(63) NOT NULL,
    "password" character(40) NOT NULL,
    firstname character varying(63) NOT NULL,
    lastname character varying(31) NOT NULL
);


ALTER TABLE public.admins OWNER TO postgres;

--
-- Name: candidates; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE candidates (
    candidateid serial NOT NULL,
    firstname character varying(63) NOT NULL,
    lastname character varying(31) NOT NULL,
    partyid integer NOT NULL,
    positionid integer NOT NULL,
    description text,
    picture character varying(255)
);


ALTER TABLE public.candidates OWNER TO postgres;

--
-- Name: parties; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE parties (
    partyid serial NOT NULL,
    party character varying(63) NOT NULL,
    description text,
    logo character varying(255)
);


ALTER TABLE public.parties OWNER TO postgres;

--
-- Name: positions; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE positions (
    positionid serial NOT NULL,
    "position" character varying(63) NOT NULL,
    description text,
    maximum smallint NOT NULL,
    ordinality smallint NOT NULL,
    abstain smallint NOT NULL,
    unit smallint
);


ALTER TABLE public.positions OWNER TO postgres;

--
-- Name: voters; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE voters (
    voterid serial NOT NULL,
    email character varying(63) NOT NULL,
    "password" character(40) NOT NULL,
    pin character varying(40) NOT NULL,
    firstname character varying(63) NOT NULL,
    lastname character varying(31) NOT NULL,
    voted smallint DEFAULT 0 NOT NULL,
    unitid integer
);


ALTER TABLE public.voters OWNER TO postgres;

--
-- Name: votes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE votes (
    voterid integer NOT NULL,
    candidateid integer NOT NULL,
    "timestamp" timestamp without time zone NOT NULL
);


ALTER TABLE public.votes OWNER TO postgres;

--
-- Name: admins_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY admins
    ADD CONSTRAINT admins_pkey PRIMARY KEY (adminid);


--
-- Name: candidates_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY candidates
    ADD CONSTRAINT candidates_pkey PRIMARY KEY (candidateid);


--
-- Name: parties_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY parties
    ADD CONSTRAINT parties_pkey PRIMARY KEY (partyid);


--
-- Name: positions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY positions
    ADD CONSTRAINT positions_pkey PRIMARY KEY (positionid);


--
-- Name: voters_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY voters
    ADD CONSTRAINT voters_email_key UNIQUE (email);


--
-- Name: voters_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY voters
    ADD CONSTRAINT voters_pkey PRIMARY KEY (voterid);


--
-- Name: votes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY votes
    ADD CONSTRAINT votes_pkey PRIMARY KEY (voterid, candidateid);


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY candidates
    ADD CONSTRAINT "$1" FOREIGN KEY (partyid) REFERENCES parties(partyid) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: $1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY votes
    ADD CONSTRAINT "$1" FOREIGN KEY (voterid) REFERENCES voters(voterid) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY candidates
    ADD CONSTRAINT "$2" FOREIGN KEY (positionid) REFERENCES positions(positionid) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: $2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY votes
    ADD CONSTRAINT "$2" FOREIGN KEY (candidateid) REFERENCES candidates(candidateid) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: voters_unitid_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY voters
    ADD CONSTRAINT voters_unitid_fkey FOREIGN KEY (unitid) REFERENCES positions(positionid) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

