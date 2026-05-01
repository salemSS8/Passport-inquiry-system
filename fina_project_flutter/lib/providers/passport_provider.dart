import 'package:flutter_riverpod/legacy.dart';
import '../models/passport_model.dart';
import '../services/api_service.dart';

class PassportState {
  final bool isLoading;
  final String? error;
  final PassportModel? passportData;

  PassportState({this.isLoading = false, this.error, this.passportData});

  PassportState copyWith({
    bool? isLoading,
    String? error,
    bool clearError = false,
    PassportModel? passportData,
    bool clearData = false,
  }) {
    return PassportState(
      isLoading: isLoading ?? this.isLoading,
      error: clearError ? null : (error ?? this.error),
      passportData: clearData ? null : (passportData ?? this.passportData),
    );
  }
}

class PassportNotifier extends StateNotifier<PassportState> {
  final ApiService _apiService = ApiService();

  PassportNotifier() : super(PassportState());

  Future<void> fetchPassportData(String serialNumber) async {
    state = state.copyWith(isLoading: true, clearError: true);

    try {
      final data = await _apiService.trackPassport(serialNumber);

      state = state.copyWith(
        isLoading: false,
        passportData: data,
        clearError: true,
      );
    } catch (e) {
      final errorMessage = e.toString().replaceAll('Exception: ', '');

      state = state.copyWith(
        isLoading: false,
        error: errorMessage,
        clearData: true,
      );
    }
  }
}

final passportProvider = StateNotifierProvider<PassportNotifier, PassportState>(
  (ref) => PassportNotifier(),
);
