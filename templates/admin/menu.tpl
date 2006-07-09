<h2>Menu</h2>

<p><a href="adminhome">
{if $MODULE_NAME|lower eq "adminhome"}
>>
{/if}
Home</a></p>

<p><a href="candidates">
{if $MODULE_NAME|lower eq "candidates"}
>>
{/if}
Candidates</a></p>

{if $MODULE_NAME|lower eq "addcandidate"}
<p>&nbsp;>> Add Candidate</p>
{/if}

{if $MODULE_NAME|lower eq "editcandidate"}
<p>&nbsp;>> Edit Candidate</p>
{/if}

{if $MODULE_NAME|lower eq "viewcandidate"}
<p>&nbsp;>> View Candidate</p>
{/if}

<p><a href="positions">
{if $MODULE_NAME|lower eq "positions"}
>>
{/if}
Positions</a></p>

{if $MODULE_NAME|lower eq "addposition"}
<p>&nbsp;>> Add Position</p>
{/if}

{if $MODULE_NAME|lower eq "editposition"}
<p>&nbsp;>> Edit Position</p>
{/if}

{if $MODULE_NAME|lower eq "viewposition"}
<p>&nbsp;>> View Position</p>
{/if}

<p><a href="parties">
{if $MODULE_NAME|lower eq "parties"}
>>
{/if}
Parties</a></p>

{if $MODULE_NAME|lower eq "addparty"}
<p>&nbsp;>> Add Party</p>
{/if}

{if $MODULE_NAME|lower eq "editparty"}
<p>&nbsp;>> Edit Party</p>
{/if}

{if $MODULE_NAME|lower eq "viewparty"}
<p>&nbsp;>> View Party</p>
{/if}

<p><a href="voters">
{if $MODULE_NAME|lower eq "voters"}
>>
{/if}
Voters</a></p>

{if $MODULE_NAME|lower eq "addvoter"}
<p>&nbsp;>> Add Voter</p>
{/if}

{if $MODULE_NAME|lower eq "editvoter"}
<p>&nbsp;>> Edit Voter</p>
{/if}

{if $MODULE_NAME|lower eq "viewvoter"}
<p>&nbsp;>> View Voter</p>
{/if}

<p><a href="logout.do">Logout</a></p>