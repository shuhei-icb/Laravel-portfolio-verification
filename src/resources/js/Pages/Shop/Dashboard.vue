<script setup lang="ts">
import { Head } from "@inertiajs/vue3";

const salesData = [
	{ name: "商品A", count: 10000 },
	{ name: "商品B", count: 5000 },
	{ name: "商品C", count: 100 },
];

const salesData2 = [
	{ date: "5月2日（金）", amount: 10000 },
	{ date: "5月1日（木）", amount: 5000 },
	{ date: "4月30日（水）", amount: 100 },
];

const salesData3 = [
	{
		id: 1,
		status: "発送済",
		product: "商品A",
		quantity: 1,
		amount: 1000,
		date: "2025/4/30 00:00",
	},
	{
		id: 2,
		status: "発送済",
		product: "商品A",
		quantity: 1,
		amount: 1000,
		date: "2025/4/30 00:00",
	},
	{
		id: 3,
		status: "発送済",
		product: "商品A",
		quantity: 1,
		amount: 1000,
		date: "2025/4/30 00:00",
	},
];
</script>

<template>
	<Head title="Shop | Dashboard" />
	<div class="container-fluid p-0">
		<div v-if="$page.props.flash.message" class="alert alert-success my-3 text-center">
			{{ $page.props.flash.message }}
		</div>
		<div class="row mt-5">
			<div class="col-md-6 px-5">
				<div class="card shadow">
					<div class="card-header">売上ランキング</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover align-middle">
								<tbody>
									<tr v-for="(item, index) in salesData" :key="item.name">
										<td>
											<span class="badge bg-primary fs-6">{{
												index + 1
											}}</span>
										</td>
										<td>{{ item.name }}</td>
										<td>{{ item.count.toLocaleString() }} 個</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 px-5">
				<div class="card shadow">
					<div class="card-header text-primary fw-bold">売上金額</div>
					<div class="card-body">
						<table class="table">
							<tbody>
								<tr v-for="(item, index) in salesData2" :key="item.date">
									<td>{{ item.date }}</td>
									<td>{{ item.amount.toLocaleString() }} 円</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 px-5 mt-5">
				<div class="card shadow">
					<div class="card-header">注文履歴</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover align-middle">
								<thead class="table-light">
									<tr>
										<th scope="col">id</th>
										<th scope="col">ステータス</th>
										<th scope="col">商品</th>
										<th scope="col">個数</th>
										<th scope="col">金額</th>
										<th scope="col">購入日時</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(item, index) in salesData3" :key="item.id">
										<td>{{ item.id }}</td>
										<td>
											<span class="badge bg-success">{{
												item.status
											}}</span>
										</td>
										<td>{{ item.product }}</td>
										<td>{{ item.quantity }}</td>
										<td>{{ item.amount }}</td>
										<td>{{ item.date }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
