<html>
	<body>
<div>
	<table class="scores-table">
		<thead>
			<tr>
				<th scope="col"></th>
				<th scope="col">Q1</th>
				<th scope="col">Q2</th>
				<th scope="col">Q3</th>
				<th scope="col">Q4</th>
				<th scope="col" class="ot hidden">OT</th>
				<th scope="col">Total</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="home-acrynm"><?=$home->getAcronym();?></td>
				<td class="home q1"><?=$home1Q;?></td>
				<td class="home q2"><?=$home2Q;?></td>
				<td class="home q3"><?=$home3Q;?></td>
				<td class="home q4"><?=$home4Q;?></td>
				<td class="home ot hidden"><?=$home4Q;?></td>
				<td class="home totalscore"><?=$homescore;?></td>
			</tr>
			<tr>
				<td class="away-acrynm"><?=$away->getAcronym();?></td>
				<td class="away q1"><?=$away1Q;?></td>
				<td class="away q2"><?=$away2Q;?></td>
				<td class="away q3"><?=$away3Q;?></td>
				<td class="away q4"><?=$away4Q;?></td>
				<td class="away ot hidden"><?=$away5Q;?></td>
				<td class="away totalscore"><?=$awayscore;?></td>
			</tr>
		</tbody>
	</table>
	<div class="recentplay">
		<div class="recentplay-inner">
			<div class="position"></div>
			<div class="playtext"></div>
		</div>
	</div>
	<div class="summary">
		<h4>Scoring Plays:</h4>
		<table id="summary-table">

		</table>
	</div>
</div>
	</body>
</html>
