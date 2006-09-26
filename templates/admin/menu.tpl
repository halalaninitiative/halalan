<h2>Menu</h2>

<p><a href="adminhome">
{if $MODULE_NAME|lower eq "adminhome"}
&raquo;
{/if}
Home</a></p>

<p><a href="candidates">
{if $MODULE_NAME|lower eq "candidates"}
&raquo;
{/if}
Candidates</a></p>

{if $MODULE_NAME|lower eq "addcandidate"}
<p>&nbsp;&raquo; Add Candidate</p>
{/if}

{if $MODULE_NAME|lower eq "editcandidate"}
<p>&nbsp;&raquo; Edit Candidate</p>
{/if}

{if $MODULE_NAME|lower eq "viewcandidate"}
<p>&nbsp;&raquo; View Candidate</p>
{/if}

<p><a href="positions">
{if $MODULE_NAME|lower eq "positions"}
&raquo;
{/if}
Positions</a></p>

{if $MODULE_NAME|lower eq "addposition"}
<p>&nbsp;&raquo; Add Position</p>
{/if}

{if $MODULE_NAME|lower eq "editposition"}
<p>&nbsp;&raquo; Edit Position</p>
{/if}

{if $MODULE_NAME|lower eq "viewposition"}
<p>&nbsp;&raquo; View Position</p>
{/if}

<p><a href="parties">
{if $MODULE_NAME|lower eq "parties"}
&raquo;
{/if}
Parties</a></p>

{if $MODULE_NAME|lower eq "addparty"}
<p>&nbsp;&raquo; Add Party</p>
{/if}

{if $MODULE_NAME|lower eq "editparty"}
<p>&nbsp;&raquo; Edit Party</p>
{/if}

{if $MODULE_NAME|lower eq "viewparty"}
<p>&nbsp;&raquo; View Party</p>
{/if}

<p><a href="voters">
{if $MODULE_NAME|lower eq "voters"}
&raquo;
{/if}
Voters</a></p>

{if $MODULE_NAME|lower eq "addvoter"}
<p>&nbsp;&raquo; Add Voter</p>
{/if}

{if $MODULE_NAME|lower eq "editvoter"}
<p>&nbsp;&raquo; Edit Voter</p>
{/if}

{if $MODULE_NAME|lower eq "viewvoter"}
<p>&nbsp;&raquo; View Voter</p>
{/if}

<p><a href="logout.do">Logout</a></p>